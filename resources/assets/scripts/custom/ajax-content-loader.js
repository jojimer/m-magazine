export default {
	staticData() {
		return {
			'container': $('#dynamic-container'),
			'offset': 3,
		}
	},
	init(page) {
		// Set function for scrolling at the bottom and load content
		let loadContentAtTheBottom = () => {
			if(!$('body').hasClass('single') && !$('.main').hasClass(page+'-ended') && page){
				let d = document.documentElement;
				let offset = d.scrollTop + window.innerHeight;
				let height = d.offsetHeight;

				if (offset >= height && $('#loading-content').hasClass('d-none')) {
					$('#loading-content').removeClass('d-none');
					this.getContent(page);
				}
			}else{
				$('#loading-content').removeClass('d-none');
				setTimeout(function(){
					$('#loading-content').html('<p class="h3">No more '+page+' available!</p>').addClass('py-4').removeClass('d-none');
				},2500)
			}		
		}

		if(page && !$('.main').hasClass(page+'-event-active')){
			window.addEventListener('scroll', loadContentAtTheBottom, true)
		}
	},	
	getContent(page) {		
		// galleryUpdate,fieldReportUpdate,homeUpdate;

		let contentNumbers,
		data = this.staticData();

		// News Content Loader Function
		const loadNews = function () {
			contentNumbers = data.container.data(page+'-numbers');
			return new Promise((resolve, reject) => {
			$.ajax({
					url: '/content-api/news/'+contentNumbers,
					type: 'GET',
					success: function (data) {
						resolve(data)
					},
					error: function (error) {
						reject(error)
					},
				})				
			})
		}

		loadNews().then(result => {			
			if(result.success && result.data.length > 0){
				if(!$('main.main').hasClass(page+'-event-active')) $('main.main').addClass(page+'-event-active');
				let randomNumber = this.getRandomNumber();				
				setTimeout(function(){
					$('#loading-content').addClass('d-none');
					data.container.data(page+'-numbers',contentNumbers + data.offset)
					data.container.append(result.data);
					window.newsUpdate.pageSkipped = contentNumbers + data.offset;
					$('#loading-content').appendTo(data.container);
					if(window.newsUpdate.content !== 0){
						window.newsUpdate.content += (page === 'news') ? result.data : '';
					}else{
						window.newsUpdate.content = result.data;
					}
				},randomNumber)
			}else{
				$('main.main').addClass(page+'-ended');
				setTimeout(function(){
					$('#loading-content').html('<p class="h3">No more '+page+' available!</p>').addClass('py-4').removeClass('d-none');
				},2500)
			}
		}, err => {
			if(err) this.init(false);
		})
	},
	getRandomNumber() {
		return Math.floor(Math.random() * (5 - 3 + 1) + 3) * 1000;
	},
}