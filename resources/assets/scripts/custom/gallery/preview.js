export default {
  // JavaScript to be fired on the galleries page 
  init() {
    // Get Images Value
    let getImages = function(trigger){
      let n = {
        'images' : trigger.parents('.gallery-preview-block').find('.gallery-preview-images>ol>li'),
        'translateWidth' : [],
      }

      for(let i = 0; n.images.length > i; i++){         
        if(i !== 0){
          n.translateWidth[i] = n.images[i].getBoundingClientRect().width + n.translateWidth[i-1];
        }else{
          n.translateWidth[i] = 0;
        }
      }

      return n;
    }

    // Move Control Button
    let moveControlButton = function(trigger,index,img){
      let imagesController = $(trigger).parents('.gallery-preview-block').find('.gallery-preview-control>ol>li'),
      img_position = (index < img.length - 3) ? index : img.length - 3;

      imagesController.addClass('img-hidden');
      $(imagesController[img_position]).removeClass('img-hidden');
      $(imagesController[img_position+1]).removeClass('img-hidden');
      $(imagesController[img_position+2]).removeClass('img-hidden');
      return img_position;
    }

    // Slide images in gallery preview controller
    $(document).on('click','.gallery-preview-control>ol>li.img-hidden',function(){
      // Get Images index
      let x = getImages($(this));
      let ol = $(this).parents('.gallery-preview-block').find('.gallery-preview-images>ol') 

      // Translate images
      let controllerIndex = $(this).data('index');
      let position = moveControlButton(this,controllerIndex,x.images)
      $(ol).css('transform','translateX(-'+x.translateWidth[position]+'px)');
    });

    // Slide images in gallery by every 2 seconds
    $(document).on('mouseenter','#imagesContainer',function(){
      let olWrap = $(this).find('.gallery-slider-wrap'),
      button = $(this).parents('.gallery-preview-block').find('.gallery-preview-control>ol>li.img-hidden')
      if(!olWrap.hasClass('prev-sliding')){
        // Get Images index
        let x = getImages($(this));
        let allImages = x.images.length
        let t = 1;
             
        let slideTimer = setInterval(function(){          
          if(t < allImages - 2){  
            olWrap.addClass('prev-sliding')
            moveControlButton(button,t,x.images)
            $(olWrap).css('transform','translateX(-'+x.translateWidth[t]+'px)');
            t++
          }else{            
            clearInterval(slideTimer)            
          }
        },2000)
      }
    })    
  },
};