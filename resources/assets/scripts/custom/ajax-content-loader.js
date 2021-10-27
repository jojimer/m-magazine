export default {
	staticData() {
		return {
			'container': $('#dynamic-container'),
			'posts_per_page': 3,
			'post_type' : {'home' : 'home','news' : 'news', 'galleries' : 'gallery', 'shop' : 'shop-product', 'field-reports' : 'field-report' },
		}
	},
	init() {
		// Set function for scrolling at the bottom and load content
		const loadContentAtTheBottom = () => {
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
				let textPage = (page !== 'home') ? ' '+page : '';
				$('#loading-content').removeClass('d-none');
				setTimeout(function(){					
					$('#dynamic-container[data-barba-namespace='+page+'] #loading-content').html('<p class="h3">No more'+ textPage +' content available!</p>').addClass('py-4').removeClass('d-none');
				},1500)
			}		
		}

		return loadContentAtTheBottom;
	},
	getContent(post_type,page) {		
		// galleryUpdate,fieldReportUpdate,homeUpdate;

		let contentLoaded = '['+window.contentUpdate.exclude[page]+']';
		let staticData = this.staticData();
		// News Content Loader Function
		const loadNews = function () {
			return new Promise((resolve, reject) => {
			$.ajax({
					url: '/content-api/'+post_type+'/'+contentLoaded+'/'+staticData.posts_per_page,
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
			if(result.success && result.data.content.length > 0){
				if(!$('main.main').hasClass(page+'-event-active')) $('main.main').addClass(page+'-event-active');
				let randomNumber = this.getRandomNumber();
				setTimeout(function(){
					$('#loading-content').addClass('d-none');
					staticData.container.append(result.data.content);
					$('#loading-content').appendTo(staticData.container);
					if(window.contentUpdate.content[page] !== 0 && page !== 'home'){
						window.contentUpdate.content[page] += result.data.content;
					}else if(page !== 'home'){
						window.contentUpdate.content[page] = result.data.content;						
					}else{
						window.contentUpdate.content[page] = staticData.container.html();
					}
					window.contentUpdate.exclude[page] = result.data.exclude;	
				},randomNumber)
			}else{
				$('main.main').addClass(page+'-ended');
			}
		}, err => {
			if(err) console.log(err);
		})
	},
	getRandomNumber() {
		return Math.floor(Math.random() * (5 - 3 + 1) + 3) * 1000;
	},
}