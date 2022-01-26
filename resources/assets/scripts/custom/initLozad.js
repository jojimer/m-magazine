import lozad from 'lozad';

export default {
	init(classSelector) {
      //Observe selected img element
      return lozad(classSelector, {
        rootMargin: '500px 0px',
        threshold: 0.1,
        load: function(el) {          
          if(classSelector === '.lozad'){
            el.src = el.dataset.src;
            el.classList.remove('lozad');
          }else{
            el.style.backgroundImage = 'url('+el.dataset.src+')';
            setTimeout(function(){
              el.classList.remove('bg-lozad');
            },500)
          }          
        },
      });
    },
}