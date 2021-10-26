export default {
	staticData() {
		return {
			'container': $('#dynamic-container'),
			'offset': 3,
			'post_type' : {'news' : 'news', 'galleries' : 'gallery', 'shop' : 'shop-product', 'field-reports' : 'field-report' },
		}
	},
	init() {
		// Set function for scrolling at the bottom and load content
		let loadContentAtTheBottom = () => {
			let page = this.staticData().container.data('barba-namespace');
			if(!$('body').hasClass('single') && !$('main.main').hasClass(page+'-ended') && page){
				let d = document.documentElement;
				let offset = d.scrollTop + window.innerHeight;
				let height = d.offsetHeight;

				if (offset >= height-100 && $('#loading-content').hasClass('d-none')) {
					$('#loading-content').removeClass('d-none');
					this.getContent(this.staticData().post_type[page],page);
				}
			}else{
				$('#loading-content').removeClass('d-none');
				setTimeout(function(){
					$('#dynamic-container[data-barba-namespace='+page+'] #loading-content').html('<p class="h3">No more '+page+' content available!</p>').addClass('py-4').removeClass('d-none');
				},1500)
			}		
		}

		return loadContentAtTheBottom;
	},	
	getContent(post_type,page) {		
		// galleryUpdate,fieldReportUpdate,homeUpdate;

		let contentLoaded,
		data = this.staticData();

		// News Content Loader Function
		const loadNews = function () {
			contentLoaded = data.container.data(page+'-numbers');
			return new Promise((resolve, reject) => {
			$.ajax({
					url: '/content-api/'+post_type+'/'+contentLoaded+'/'+data.offset,
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
					data.container.data(page+'-numbers',contentLoaded + data.offset)
					data.container.append(result.data);
					window.contentUpdate.pageSkipped[page] = contentLoaded + data.offset;
					$('#loading-content').appendTo(data.container);
					if(window.contentUpdate.content[page] !== 0){
						window.contentUpdate.content[page] += result.data;
					}else{
						window.contentUpdate.content[page] = result.data;
					}
				},randomNumber)
			}else{
				$('main.main').addClass(page+'-ended');
				setTimeout(function(){
					$('#dynamic-container[data-barba-namespace='+page+'] #loading-content').html('<p class="h3">No more '+page+' content available!</p>').addClass('py-4').removeClass('d-none');
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