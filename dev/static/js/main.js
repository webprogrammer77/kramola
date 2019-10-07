$(function() {
  svg4everybody({});

  $(".smart-basket__wrapper").smbasket({
    productElement: "product",
    buttonAddToBasket: "product__add-to-cart-button",
    countryCode: "",
    smartBasketCurrency: "₽",
    productQuantityWrapper: "product__quantity",
    smartBasketMinArea: "header__basket-min",
    smartBasketMinText: "",
    smartBasketMinIconPath: "smartbasket/img/shopping-basket-wight.svg",
    telIsRequired: true,
    emailIsRequired: false,
    productPrice: "product__price-number",
    productSize: "product__size"
  });
  var inputAdress_old =
    '<div class="smart-basket__input-wrapper adress" style="width:100%; margin-top:7px;"><input class="smart-basket__user-input" type="text" placeholder="Введите адрес" name="userAdress"><p style="margin-top:10px;">Доставляем книги по России и во все страны мира. Стоимость доставки в ваш регион вам сообщит менеджер после оформления заказа!</p></div>';
  var inputAdress =
    '<p class="smart-basket__delivery-title">Выберите способ доставки:</p><div class="smart-basket__input-wrapper pikup" style="width:100%; margin-top:7px;"><input class="smart-basket__radio-input" type="radio" id="pickup" name="dostavka" value="Самовывоз"><label for="pickup">Самовывоз по адресу: г.Москва, Большой Факельный переулок д.3 стр.2</label></div><div class="smart-basket__input-wrapper adress" style="width:100%; margin-top:7px;"><input class="smart-basket__radio-input" type="radio" id="delivery" name="dostavka" value="Доставка"><label for="delivery">Доставка</label><input class="smart-basket__user-input" type="text" placeholder="Введите адрес доставки" name="userAdress"><p style="margin-top:10px;">Доставляем книги по России и во все страны мира. Стоимость доставки в ваш регион вам сообщит менеджер после оформления заказа!</p></div>';

  /*-----------------------------------*/
  var modalSuccess =
    '<div class="success_wrapper smart-basket__alert-wrapper"><div class="smart-basket__alert"><div class="smart-basket__alert-icon"><svg class="" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"></circle><polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "></polyline></svg></div><div class="smart-basket__alert-text">Спасибо за покупку! <br> Наш менеджер свяжется с вами.</div><div class="smart-basket__alert-footer" style="justify-content:center;"><button class="smart-basket__alert-button smart-basket__alert-button_close success">Продолжить покупки</button></div></div></div>';

  $(document).on("click", ".smart-basket__send-form", function(e) {
		$(this).prop("disabled", true);
    $("body").css("overflow", "auto");
    setTimeout(function() {
      $(".smart-basket").toggleClass("smart-basket_active");
      $("body").css("overflow", "auto");
      $("body").append(modalSuccess);
    }, 1500);
  });
  $(document).on("click", ".success.smart-basket__alert-button_close", function(
    e
  ) {
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

	var pathname = window.location.pathname;
	var current_href = pathname.replace('/', '');
	var nav_links = $('.nav-header__link');
	if(pathname == '/'){
		current_href = 'index.html';
	}
	
	$.each(nav_links, function(index, value) {
		if($(this).attr('href') == current_href){
			nav_links.not($(this)).parent().removeClass('active');
			$(this).parent().addClass('active');
		}
	});

  $(document).on("click", ".nav-header__btn", function(e) {
    $("body").toggleClass("noScroll");
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

  var dropTop = $('<div id="scrolTop" hidden></div>').appendTo("body");
  var skrollTopInit = function() {
    if ($(document).scrollTop() >= 400) {
      dropTop.fadeIn(300);
    } else {
      dropTop.fadeOut(300);
    }
  };

  skrollTopInit();

  $(document).on("scroll", function() {
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

  /*----------------//localStorage-----------------------*/
  /*------------------------sendpulse--------------------*/

  $("button[sp-show-form]").on("click", function() {
    $(".sp-checkbox-option [type=checkbox]").attr("checked", true);
  });

  /*----------------------//sendpulse--------------------*/
});
