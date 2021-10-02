export default {
	init() {
		$(document).on('click','.gallery-single-wrap section img',function() {
			$('.image-lightbox').fadeIn(300);
			$('.image-lightbox .img-container').append('<img class="single-img" src="' + $(this).attr('src') + '" alt="' + $(this).attr('alt') + '" />');
			$('.filter').css('background-image', 'url(' + $(this).attr('src') + ')');
			$('.title').append('<h1>' + $(this).attr('alt') + '</h1>');
			$('html').css('overflow', 'hidden');
			if ($(this).is(':last-child')) {
				$('.arrowr').css('display', 'none');
				$('.arrowl').css('display', 'block');
			} else if ($(this).is(':first-child')) {
				$('.arrowr').css('display', 'block');
				$('.arrowl').css('display', 'none');
			} else {
				$('.arrowr').css('display', 'block');
				$('.arrowl').css('display', 'block');
			}
		});

		$(document).on('click','.close',function() {
			$('.image-lightbox').fadeOut(300);
			$('.title h1').remove();
			$('.image-lightbox img').remove();
			$('html').css('overflow', 'auto');
		});

		$(document).keyup(function(e) {
			if (e.keyCode == 27) {
				$('.image-lightbox').fadeOut(300);
				$('.image-lightbox img').remove();
				$('html').css('overflow', 'auto');
			}
		});

		$(document).on('click','.arrowr',function() {
			let imgSrc = $('.image-lightbox img').attr('src');
			let search = $('section').find('img[src$="' + imgSrc + '"]');
			let newImage = search.next().attr('src');
			let newTitle = search.next().attr('alt');
			$('.title h1').text(newTitle);
			/*$('.image-lightbox img').attr('src', search.next());*/
			$('.image-lightbox img').attr('src', newImage);
			$('.filter').css('background-image', 'url(' + newImage + ')');

			if (!search.next().is(':last-child')) {
				$('.arrowl').css('display', 'block');
			} else {
				$('.arrowr').css('display', 'none');
			}
		});

		$(document).on('click','.arrowl',function() {
			let imgSrc = $('.image-lightbox img').attr('src');
			let search = $('section').find('img[src$="' + imgSrc + '"]');
			let newImage = search.prev().attr('src');
			let newTitle = search.prev().attr('alt');
			$('.title h1').text(newTitle);
			/*$('.image-lightbox img').attr('src', search.next());*/
			$('.image-lightbox img').attr('src', newImage);
			$('.filter').css('background-image', 'url(' + newImage + ')');

			if (!search.prev().is(':first-child')) {
				$('.arrowr').css('display', 'block');
			} else {
				$('.arrowl').css('display', 'none');
			}
		});
	},
	finalize() {

	},
}