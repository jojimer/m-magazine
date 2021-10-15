export default {
	init() {
		// Get Barba Dynamic Container
		let dynamicContainer = $('#dynamic-container');		
		let newsNumbers,
		ContentOffset = 3;

		// News Content Loader Function
		const loadNews = function () {
			newsNumbers = dynamicContainer.data('content-numbers');
			return new Promise((resolve, reject) => {
			$.ajax({
					url: '/content-api/news/'+newsNumbers,
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

		window.onscroll = () => {
			let d = document.documentElement;
			let offset = d.scrollTop + window.innerHeight;
			let height = d.offsetHeight;

			if (offset >= height) {
				console.log('At the bottom');
				loadNews().then(result => {
					if(result.success && result.data.length > 0){
						dynamicContainer.append(result.data);
						dynamicContainer.data('content-numbers',newsNumbers + ContentOffset)
						console.log(newsNumbers)
					}else{
						console.log('No More Content Available');
					}
				}, err => {
					console.log(err);
				})
			}
		}
	},
}