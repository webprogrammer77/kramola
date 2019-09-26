$(function() {
  svg4everybody({});

  $(".smart-basket__wrapper").smbasket({
    productElement: "product",
    buttonAddToBasket: "product__add-to-cart-button",
    countryCode: "",
    smartBasketCurrency: "₽",
    productQuantityWrapper: "product__quantity",
    smartBasketMinArea: "header__basket-min",
    smartBasketMinText: '',
    smartBasketMinIconPath: "/smartbasket/img/shopping-basket-wight.svg",
    telIsRequired: true,
    emailIsRequired: false,
    productPrice: "product__price-number",
    productSize: "product__size"
  });
  var inputAdress =
    '<div class="smart-basket__input-wrapper adress" style="width:100%; margin-top:7px;"><input class="smart-basket__user-input" type="text" placeholder="Введите адрес" name="userAdress"><p style="margin-top:10px;">Доставляем книги по России и во все страны мира. Стоимость доставки в ваш регион вам сообщит менеджер после оформления заказа!</p></div>';
    
    /*-----------------------------------
    var modalSuccess =
    '<div class="success_wrapper smart-basket__alert-wrapper"><div class="smart-basket__alert"><div class="smart-basket__alert-icon"><svg class="" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"></circle><polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "></polyline></svg></div><div class="smart-basket__alert-text">Спасибо за покупку! <br> Наш менеджер свяжется с вами.</div><div class="smart-basket__alert-footer" style="justify-content:center;"><button class="smart-basket__alert-button smart-basket__alert-button_close success">Продолжить покупки</button></div></div></div>';

  /*$("#smart-basket__form").on("submit", function(e) {
  $(document).on("click", ".smart-basket__send-form", function(e) {
    $("body").css("overflow", "auto");
    setTimeout(function() {
     
			 $(".smart-basket").toggleClass("smart-basket_active");
       $("body").css("overflow", "auto");
      $("body").append(modalSuccess);
    }, 1500);
  });
  $(document).on("click",".success.smart-basket__alert-button_close", function(e) {
    
		$(".success_wrapper").fadeOut(400);
		$(".smart-basket__alert").slideUp(400);
		
    setTimeout(function() {
      $(".success_wrapper").remove();      
      localStorage.clear();
      $(".smart-basket__min-count").html(0);
    }, 400);
  });


  
    /*-----------------------------------*/
    
  setTimeout(function() {
    if ($(".smart-basket__input-wrapper.adress").length == 0) {
    $(".smart-basket__user-info").append(inputAdress);
    }
  }, 200);

  $(document).on("click", ".smart-basket__min", function(e) {
    $("body").css("overflow", "auto");
    if ($(".smart-basket__input-wrapper.adress").length == 0) {
      $(".smart-basket__user-info").append(inputAdress);
    }
    
    addQuantityHtml();
  });

  $(document).on(
    "click",
    ".smart-basket__alert-button.smart-basket__alert-button_by",
    function(e) {
      if ($(".smart-basket__input-wrapper.adress").length == 0) {
        $(".smart-basket__user-info").append(inputAdress);
      }
      addQuantityHtml();
    }
  );

  $("body").on(
    "click",
    ".smart-basket__alert-button.smart-basket__alert-button_close",
    function(e) {
      addQuantityHtml();
    }
  );
  $("body").on("click", ".smart-basket__add-item", function(e) {
    addQuantityHtml();
  });

  $("body").on("click", ".smart-basket__remove-item", function(e) {
    addQuantityHtml();
  });
  $(document).on("click", ".smart-basket__product-delete", function(e) {
    addQuantityHtml();
  });

  $(document).on("click", ".smart-basket__product-devare", function(e) {
    addQuantityHtml();
  });

  function addQuantityHtml() {
    var elem = $(".smart-basket__product-price .smart-basket__input");
    var count = 0,
      total = 0;
    $.each(elem, function(index, value) {
      var quantity = $(this)
        .parent()
        .parent()
        .find(".smart-basket__product-quantity .smart-basket__input")
        .val();
      var totalThis = +$(value).val() * +quantity;
      total += +$(value).val() * +quantity;
      count += +quantity;
      $(this)
        .parent()
        .parent()
        .find(".smart-basket__product-price-common")
        .html(totalThis + "");
      $(".smart-basket__quantity-common").html(
        "<span>Всего товаров: </span> " + count
      );
      $(".smart-basket__price-common").html(
        "<span>Общая стоимость: </span> " + total + ".00 ₽"
      );
      $(".smart-basket__min-count").html(count + "");
    });
  }
  
  function addQuantityHtmlOld() {
    var elem = $(".smart-basket__product-price .smart-basket__input");
    var count = 0,
      total = 0;
    $.each(elem, function(index, value) {
      var quantity = $(this)
        .parent()
        .parent()
        .find(".smart-basket__product-quantity .smart-basket__input")
        .val();
      total += +$(value).val() * +quantity;
      count += +quantity;
      $(".smart-basket__quantity-common").html(
        "<span>Всего товаров: </span> " + count
      );
      $(".smart-basket__price-common").html(
        "<span>Общая стоимость: </span> " + total + ".00 ₽"
      );
      $(".smart-basket__min-count").html(count);
    });
  }

  $(document).on("click", ".nav-header__btn", function(e) {
    $(this).toggleClass("active");
    $(this)
      .parent()
      .find("ul.nav-header__list")
      .toggleClass("active");
    $(".header__basket-min").toggleClass("hide");
  });
  $(document).on("click", ".nav-footer__link", function(e) {
    setProductsLocalstorage();
  });
  $(document).on("click", ".nav-header__link", function(e) {
    setProductsLocalstorage();
  });

  /*-------scrolTop------------*/
  /*
var dropTop = $('<div>')
.appendTo($('body'))
.addClass('dropTop').css({
	'width': '70px',
	'height': '70px',
	'position': 'fixed',
	'bottom': '10px',
	'right': '10px',
	'background': 'rgba(0,0,0,0.3)',
	'borderRadius': '5px',
	'zIndex': '1000',
	'display': 'none',
	'cursor': 'pointer',
	'textAlign':'center'
});
*/
  var dropTop = $('<div id="scrolTop" hidden></div>').appendTo("body");
  var skrollTopInit = function() {
    if ($(document).scrollTop() >= 400) {
      dropTop.fadeIn(300);
    } else {
      dropTop.fadeOut(300);
    }
  };

  skrollTopInit(); //чтобы при перезагрузке страницы кнопка показывалась

  $(document).on("scroll", function() {
    //console.log($(document).scrollTop());
    skrollTopInit();
  });

  $("#scrolTop").on("click", function() {
    $("body, html").animate(
      {
        scrollTop: 0
      },
      300
    );
  });

  /*
pageYOffset интуитивно говорит, сколько страниц было прокручено
document.scrollTop - это запасной вариант для IE <9 (кстати, в jQuery 2 он не поддерживается)
document.clientTop - ширина верхней границы элемента (в данном случае документ)
elem.getBoundingClientRect().top получает координаты относительно области просмотра
*/
  /*-------//scrolTop------------*/

  /*----------------text-----------------------*/
  /*
var textBlock = $('.product__name + p.product-desc__text');
var textContent = textBlock.text();
var textLength = textContent.length;
var size = 200;
var textContentNew = textContent.slice(0, size) + ' ...';

if(textLength > size){
	textBlock.text(textContentNew);
}

textBlock.hover( function(){
	textBlock.text(textContent);
	textBlock.css({
		//'position':'relative',
		'background':'white',
		'zIndex':100
	});
}, function(){
	textBlock.text(textContentNew);
	textBlock.css({

	});

});
*/
  /*----------------//text-----------------------*/
  /*----------------localStorage-----------------------*/
  function setProductsLocalstorage() {
    var dataproducts = {};
    var inputData = $(
      ".smart-basket__product-item .smart-basket__product-id input"
    );
    $.each(inputData, function(index, value) {
      inputData = $(this);
      var productId = inputData.val(),
        productImg = inputData
          .parent()
          .parent()
          .find(".smart-basket__product-name img")
          .attr("src"),
        productName = inputData
          .parent()
          .parent()
          .find(".smart-basket__product-name span")
          .text(),
        productQuantity = inputData
          .parent()
          .parent()
          .find(".smart-basket__product-quantity input")
          .val(),
        productPrice = inputData
          .parent()
          .parent()
          .find(".smart-basket__product-price input")
          .val();

      dataproducts[productId] = {
        sbId: productId,
        sbImg: productImg,
        sbName: productName,
        sbQuantity: productQuantity,
        sbPrice: productPrice
      };
    });

    return localStorage.setItem("basketItems", JSON.stringify(dataproducts));
  }

  function getProducts() {
    return JSON.parse(localStorage.getItem("basketItems"));
  }
  function getProduct(id) {
    var data = JSON.parse(localStorage.getItem("basketItems"));
    return data[id];
  }
  function setProducts(data) {
    var a = JSON.stringify(data, "", 4);
    return localStorage.setItem("basketItems", a), !1;
  }
  //console.log(JSON.parse(localStorage.getItem("basketItems")));

  /*----------------//localStorage-----------------------*/
});

/*-------image------------*/

/**
 * Проверка видимости элемента (в видимой части страницы)
 * Достаточно, чтобы верхний или нижний край элемента был виден
 */
/*
function isVisible(elem) {
  var coords = elem.getBoundingClientRect();

  var windowHeight = document.documentElement.clientHeight;

  // видны верхний ИЛИ нижний край элемента
  var topVisible = coords.top > 0 && coords.top < windowHeight;
  var bottomVisible = coords.bottom < windowHeight && coords.bottom > 0;

  return topVisible || bottomVisible;
}
*/

/*------------------------------------------------------------------*/
/**
    Вариант проверки, считающий элемент видимым,
    если он не более чем -1 страница назад или +1 страница вперед.

    function isVisible(elem) {

      var coords = elem.getBoundingClientRect();

      var windowHeight = document.documentElement.clientHeight;

      var extendedTop = -windowHeight;
      var extendedBottom = 2 * windowHeight;

      // top visible || bottom visible
      var topVisible = coords.top > extendedTop && coords.top < extendedBottom;
      var bottomVisible = coords.bottom < extendedBottom && coords.bottom > extendedTop;

      return topVisible || bottomVisible;
		}
		*/
/*--------------------------------------------------------------*/
/*
function showVisible() {
  for (var img of document.querySelectorAll("img")) {
    var realSrc = img.dataset.src;
    if (!realSrc) continue;

    if (isVisible(img)) {
      // отключение кеширования
      // эта строка должна быть удалена в "боевом" коде
      //realSrc += "?nocache=" + Math.random();

      img.src = realSrc;

      img.dataset.src = "";
    }
  }
}

window.addEventListener("scroll", showVisible);
showVisible();
*/
/*------------------------*/

