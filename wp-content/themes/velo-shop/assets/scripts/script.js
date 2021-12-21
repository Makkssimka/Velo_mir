"use strict";

jQuery(document).ready(function ($) {
  var selectList = $(".select-input");
  selectList.each(function (index, item) {
    var defOption = $(item).find(".option-item-select").text();
    $(item).find(".select-input-value span").text(defOption);
  });
  $('.select-input-value').click(function () {
    $('.open-input-select').removeClass('open-input-select');
    $(this).parent().addClass('open-input-select');
  });
  $(".select-option-item").click(function () {
    $(".option-item-select").removeClass('option-item-select');
    $(this).addClass('option-item-select');
    var valOption = $(this).text();
    var parent = $(this).parents('.select-input');
    parent.find(".select-input-value span").text(valOption);
    parent.removeClass('open-input-select');
    var result = $(this).data('value');
    parent.trigger("change", [result]);
  });
  $(document).click(function (e) {
    if ($(e.target).parents('.select-input').length) {
      return;
    } else {
      $('.open-input-select').removeClass('open-input-select');
    }
  });

  if ($('.product').length) {
    var owlGgallery = $('#product-carousel').owlCarousel({
      dots: false,
      items: 1
    });
    $('.product-gallery-thumbnail li').click(function (e) {
      e.preventDefault();
      $('.product-gallery-thumbnail .active').removeClass('active');
      $(this).addClass('active');
      var imageNum = $(this).data('numb');
      owlGgallery.trigger('to.owl.carousel', [imageNum]);
    });
    owlGgallery.on('changed.owl.carousel', function (e) {
      $('.product-gallery-thumbnail .active').removeClass('active');
      $('[data-numb="' + e.item.index + '"]').addClass('active');
    }); // Tabs script

    $('.product-tabs-header li').click(function (e) {
      e.preventDefault();
      $('.product-tabs-header .active').removeClass('active');
      $(this).addClass('active');
      var tabs = $(this).data('tab');
      $('.product-tabs-body .active').removeClass('active');
      $('[data-tabcontent=' + tabs + ']').addClass('active');
    }); // Similar owl carousel

    var owlSimilar = $('#similar-carousel').owlCarousel({
      dots: false,
      margin: 10,
      loop: true,
      responsive: {
        0: {
          items: 1
        },
        700: {
          items: 2
        },
        1050: {
          items: 3
        },
        1250: {
          items: 4
        },
        1600: {
          items: 4
        }
      }
    });
    $('.similar-caroussel-nav').click(function (e) {
      e.preventDefault();
      var nav = $(this).data('nav');

      if (nav == "left") {
        owlSimilar.trigger('prev.owl.carousel');
      } else {
        owlSimilar.trigger('next.owl.carousel');
      }
    });
  } // Open desktop menu script


  $('.menu-open-btn').click(function () {
    $('.main_categories_list').toggleClass('top-menu-visible');
    $('.main-top-mobile-menu').toggleClass('main-top-mobile-menu-visible');
  });
  $(document).click(function (e) {
    var div = $('.main_categories_list');
    var btn = $('.menu-open-btn');

    if (!div.is(e.target) // если клик был не по нашему блоку
    && !btn.is(e.target) && div.has(e.target).length === 0) {
      // и не по его дочерним элементам
      div.toggleClass('top-menu-visible'); // скрываем его
    }
  }); // $('.menu-open-btn, .main-top-menu').mouseleave(function () {
  //     $('.main-top-menu').removeClass('top-menu-visible');
  // });
  // Open mobile menu script

  $('.mobile-menu-open-wrapper a').click(function (e) {});
  $('.main-top-mobile-menu a[href="#"]').click(function () {
    var submenu = $(this).next('ul');

    if (submenu) {
      submenu.first().css('left', '0');
    }
  });
  $('.sub-menu').prepend('<li class="mobile-menu-back"><i class="las la-arrow-left"></i><span>назад</span></li>');
  $('.mobile-menu-back').on('click', function () {
    var parent = $(this).parents('ul');
    parent.first().css('left', '-340px');
  });
  $('.mobile-menu-close').click(function () {
    $('.main-top-mobile-menu').removeClass('main-top-mobile-menu-visible');
  }); // Open desktop menu

  $('.left-menu').mouseover(function () {
    $(this).addClass('left-menu-open');
  });
  $('.left-menu').mouseout(function () {
    $(this).removeClass('left-menu-open');
  });
  $('.open-desktop-menu a').click(function (e) {
    e.preventDefault();
    $('.left-menu').toggleClass('left-menu-open');
  }); // Index page script

  if ($('.home').length) {
    var owlHome = $('#home-slider').owlCarousel({
      dots: false,
      items: 1,
      loop: true,
      autoplay: true,
      autoplayHoverPause: true,
      smartSpeed: 500
    });
    $('.home-slider-nav').click(function () {
      var action = $(this).data('action');

      if (action == "prev") {
        owlHome.trigger('prev.owl.carousel');
      } else {
        owlHome.trigger('next.owl.carousel');
      }
    });
    var priceFrom = $('#homeRange').data('price-from');
    var priceTo = $('#homeRange').data('price-to'); // отслеживаем изменения в выборе велосипедов

    $('#homeRange').ionRangeSlider({
      skin: 'round',
      type: 'double',
      step: 10,
      onFinish: function onFinish(data) {
        updateResult('price', {
          from: data.from,
          to: data.to
        });
      }
    });
    $('.home-bike-select .select-input').on('change', function (e, data) {
      var type = $(this).data('type');
      updateResult(type, data);
    });
  } //заносим данные в массив объектов


  var result_select = [];

  function updateResult(type, value) {
    // ищем есть ли в массиве уже такой объект
    var typeIndex = result_select.findIndex(function (val) {
      return val.type == type;
    }); // если пердается пустое значение удаляем объект

    if (typeIndex != -1 && !value) {
      result_select.splice(typeIndex, 1);
      getProductsCount(); // вызываем функцию запроса на сервер

      return false;
    } // если есть обновляем, если нет создаем


    if (typeIndex != -1) {
      result_select[typeIndex].type = type;
      result_select[typeIndex].value = value;
    } else {
      result_select.push({
        type: type,
        value: value
      });
    }

    getProductsCount(); // вызываем функцию запроса на сервер
  } // Функция запроса на сервер


  function getProductsCount() {
    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      dataType: "json",
      data: {
        action: 'get_products_count',
        query: result_select
      },
      beforeSend: function beforeSend() {
        $('.home-bike-select-wrapper').addClass('inactive-element');
        $('.show-bike-select-btn .btn').addClass('invisible-element');
        $('.load-progress').removeClass('invisible-element');
      },
      success: function success(response) {
        var result = response;
        $('.count-product span').text(result);

        if (result == 0) {
          $('.count-product').addClass('inactive-element');
        } else {
          $('.count-product').removeClass('inactive-element');
        }

        var link = '/bikes-catalog?session_filter';
        result_select.forEach(function (item) {
          if (item.type == 'price') {
            link += '&' + item.type + '=' + item.value.from + ',' + item.value.to;
          } else {
            link += '&' + item.type + '=' + item.value;
          }
        });
        $('.count-product').attr('href', link);
        $('.home-bike-select-wrapper').removeClass('inactive-element');
        $('.show-bike-select-btn .btn').removeClass('invisible-element');
        $('.load-progress').addClass('invisible-element');
      }
    });
  } // Catalog page script


  $('.filter-open-wrapper a, #filter_close').click(function (e) {
    e.preventDefault();
    $('.catalog-filter-wrapper').toggleClass('catalog-filter-open');
  });

  if ($('.catalog').length) {
    // filter open
    var openFilterText = 'Развернуть';
    $('.open-list-filter').click(function (e) {
      e.preventDefault();
      var parent = $(this).parents('.catalog-filter-block');
      parent.toggleClass('open-filter-block');
      openFilterText = openFilterText == 'Развернуть' ? 'Свернуть' : 'Развернуть';
      $(this).find('span').text(openFilterText);
    }); // filter price

    var priceMax = $('#priceFrom').data('price-min');
    var priceMin = $('#priceTo').data('price-max');

    var _priceFrom = $('#priceFrom').data('price-from');

    var _priceTo = $('#priceTo').data('price-to');

    $('#priceFrom').val(_priceFrom.toLocaleString());
    $('#priceTo').val(_priceTo.toLocaleString());
    $('#priceRange').ionRangeSlider({
      skin: 'round',
      type: 'double',
      min: priceMax,
      max: priceMin,
      from: _priceFrom,
      to: _priceTo,
      step: 10,
      hide_from_to: true,
      onChange: function onChange(data) {
        $('#priceFrom').val(data.from.toLocaleString());
        $('#priceTo').val(data.to.toLocaleString());
      }
    });
    var priceRange = $('#priceRange').data('ionRangeSlider');
    $('.catalog-filter-price input').on('input', function () {
      var val = Number($(this).val().replace(/\s+/g, ''));
      $(this).val(val.toLocaleString());
    });
    $('.catalog-filter-price input').change(function () {
      priceRange.update({
        from: Number($('#priceFrom').val().replace(/\s+/g, '')),
        to: Number($('#priceTo').val().replace(/\s+/g, ''))
      });
    });
  } // Article page script


  if ($('.article-blocks-wrapper').length) {
    $('.article-blocks').hover(function () {
      $('.article-blocks-active').removeClass('article-blocks-active');
      $(this).addClass('article-blocks-active');
    });
  }

  if ($('.article').length) {
    var anchorBlock = $('.anchor-list');
    var anchorList = $('.anchor-block');
    anchorList.each(function (index, item) {
      var anchorLi = document.createElement('li');
      var anchorA = document.createElement('a');
      anchorA.className = 'anchor-link';
      anchorA.href = "#" + $(item).attr('id');
      anchorA.innerText = $(item).data('link');
      anchorLi.appendChild(anchorA);
      anchorBlock[0].appendChild(anchorLi);
    });
    $('.anchor-link').on('click', function (e) {
      e.preventDefault();
      $('html, body').animate({
        scrollTop: $($(this).attr("href")).offset().top - 100
      }, 500);
    });

    if (anchorList.length) {
      var anchorArray = [];
      anchorList.each(function (index, item) {
        anchorArray.push({
          id: item.id,
          position: item.getBoundingClientRect().top + pageYOffset
        });
      });
      $(document).scroll(function () {
        $('.active-anchor').removeClass('active-anchor');
        var scroll = $(document).scrollTop();
        var arr = anchorArray.filter(function (elem) {
          return elem.position < scroll + 300;
        });
        var el = null;

        if (arr.length) {
          el = $('[href="#' + arr[arr.length - 1].id + '"]');
        } else {
          el = $('[href="#' + anchorArray[0].id + '"]');
        }

        el.addClass('active-anchor');
      });
    } else {
      $('.article-anchor-nav').css('display', 'none');
    }
  } // Compare page script
  // Modal script


  if ($('.modal-wrapper').length) {
    $('.modal-close').click(function (e) {
      e.preventDefault();
      $('.modal-wrapper').removeClass('modal-visible');
      $('#tel').val('');
      $('#name').val('');
      $('.input-danger').removeClass('input-danger');
      $('.errors-visible').removeClass('errors-visible');
    });
    $('.open-modal').click(function (e) {
      e.preventDefault();
      $('.modal-form-wrapper').removeClass('modal-block-hide');
      $('.modal-message-wrapper').addClass('modal-block-hide');
      $('.modal-wrapper').addClass('modal-visible');
      $('#tel').val('');
      $('#name').val('');
    });
    $('#tel, #telephone').mask('+7 (999) 999-99-99');
    $('.submit').click(function (e) {
      e.preventDefault();
      $('.input-danger').removeClass('input-danger');
      $('.errors-visible').removeClass('errors-visible');
      var error = false;
      var tel = $('#tel');
      var name = $('#name');

      if (!tel.val()) {
        tel.addClass('input-danger');
        tel.parents('.modal-input').find('label').addClass('errors-visible');
        error = true;
      }

      if (!name.val()) {
        name.addClass('input-danger');
        name.parents('.modal-input').find('label').addClass('errors-visible');
        error = true;
      }

      if (error) return false;
      var dd = {
        action: 'call_form_add_request',
        tel: tel.val(),
        name: name.val()
      };
      $.ajax({
        type: 'POST',
        url: window.wp_data.ajax_url,
        dataType: "json",
        data: dd,
        beforeSend: function beforeSend() {
          $('.modal-form-wrapper').addClass('modal-inactive');
        },
        success: function success(data) {
          console.log(data);
          $('.modal-form-wrapper').addClass('modal-block-hide').removeClass('modal-inactive');

          if (data) {
            $('.modal-done').removeClass('modal-block-hide');
          } else {
            $('.modal-error').removeClass('modal-block-hide');
          }
        }
      });
    });
  } // Filter submit


  $('#filter_submit').click(function (e) {
    e.preventDefault();
    var list_checkbox = $('input[type="checkbox"]');
    var value_array = {};
    list_checkbox.each(function (index, item) {
      if ($(item).is(":checked")) {
        var key = $(item).attr('name');
        var value = $(item).val();

        if (key in value_array) {
          value_array[key].push(value);
        } else {
          value_array[key] = new Array(value);
        }
      }
    });
    var price = [$('#priceFrom').val().replace(/[^\d.\-]/g, ''), $('#priceTo').val().replace(/[^\d.\-]/g, '')];
    var link = '?session_filter';

    for (var key in value_array) {
      link += '&' + key + '=' + value_array[key].join(',');
    }

    link += '&price=' + price.join(',');
    window.location.href = window.location.pathname + link;
  });
  $('#sort').on("change", function (e, result) {
    var link = '?session_sort=' + result;
    window.location.href = window.location.pathname + link;
  }); // Сортировка в поиске

  $('#search_sort').on("change", function (e, result) {
    var url_params = window.location.search.substring(1);
    url_params = new URLSearchParams(url_params);
    url_params.set('sort', result);
    url_params["delete"]('page_count');
    var link = url_params.toString();
    window.location.href = window.location.pathname + '?' + link;
  }); //Ajax
  //Добавляем в избранное

  $('.add-favorites').click(function (e) {
    e.preventDefault();
    var elem = $(this);
    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'add_favorites',
        id: elem.data('id')
      },
      beforeSend: function beforeSend() {
        elem.addClass('flicker-anim');
      },
      success: function success(response) {
        var result = JSON.parse(response);
        elem.removeClass('flicker-anim');

        if (result.status == 1) {
          elem.addClass('added-item');
        } else {
          elem.removeClass('added-item');
        }

        if (result.counter) {
          $('#favorites').text(result.counter);
          $('#favorites').removeClass('hidden-block');
        } else {
          $('#favorites').text(result.counter);
          $('#favorites').addClass('hidden-block');
        }

        if (elem.find('.result-text')) {
          elem.find('.result-text').text(result.status ? 'Добавлен в избранное' : 'В избранное');
        }
      }
    });
  }); //Удаляем из избранного

  $('.favorite-delete').click(function (e) {
    e.preventDefault();
    var elem = $(this);
    var parent = $(this).parents('.widget-bike-item');
    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'add_favorites',
        id: elem.data('id')
      },
      beforeSend: function beforeSend() {
        elem.addClass('flicker-anim');
      },
      success: function success(response) {
        var result = JSON.parse(response);
        $('#favorites').text(result.counter);
        parent.remove();

        if (!result.counter) {
          window.location.reload();
        }
      }
    });
  }); //Дабавляем в сравнение

  $('.add-compare').click(function (e) {
    e.preventDefault();
    var elem = $(this);
    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'add_compare',
        id: elem.data('id')
      },
      beforeSend: function beforeSend() {
        elem.addClass('flicker-anim');
      },
      success: function success(response) {
        var result = JSON.parse(response);
        elem.removeClass('flicker-anim');

        if (result.status == 1) {
          elem.addClass('added-item');
        } else {
          elem.removeClass('added-item');
        }

        if (result.counter) {
          $('#compare').text(result.counter);
          $('#compare').removeClass('hidden-block');
        } else {
          $('#compare').text(result.counter);
          $('#compare').addClass('hidden-block');
        }

        if (elem.find('.result-text')) {
          elem.find('.result-text').text(result.status ? 'Добавлен к сравнению' : 'В сравнение');
        }
      }
    });
  }); //Добавление в корзину

  $('.add-cart').click(function (e) {
    e.preventDefault(); //Ajax добавить в корзину

    var elem = $(this);
    var id = elem.data('id');
    var message = 'Товар ' + elem.data('name') + ' добавлен в корзину!';
    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'add_to_cart',
        id: id
      },
      beforeSend: function beforeSend() {
        elem.addClass('inactive-element');
        elem.text('Добавляем');
      },
      success: function success(response) {
        notification_add(message);
        var count = JSON.parse(response);
        $('#cart, #cart_mobile').text(count);
        $('#cart, #cart_mobile').removeClass('hidden-block');
        elem.removeClass('inactive-element').removeClass('add-cart');
        elem.text('в корзине');
        elem.unbind('click');
      }
    });
  }); //Купить в один клик

  $('.product-one-click').click(function (e) {
    e.preventDefault(); //Ajax добавить в корзину

    var id = $(this).data('id');
    var elem = $(this);
    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'add_to_cart',
        id: id
      },
      beforeSend: function beforeSend() {
        elem.addClass('inactive-element');
        elem.text('Добавляем');
      },
      success: function success(response) {
        location.assign('/checkout');
      }
    });
  }); // Работа с корзиной

  $('.up').click(function (e) {
    e.preventDefault();
    var parent = $(this).parents('.quantity-wrapper');
    var counter = parent.find('.cart-counter');
    var oldVal = Number(counter.val());

    if (oldVal + 1 > 10) {
      notification_add("Количество товаров не может привышать 10");
      return false;
    }

    counter.val(oldVal + 1);
    counter.trigger('change', {
      type: 'up'
    });
  });
  $('.down').click(function (e) {
    e.preventDefault();
    var parent = $(this).parents('.quantity-wrapper');
    var counter = parent.find('.cart-counter');
    var oldVal = Number(counter.val());

    if (oldVal - 1 == 0) {
      notification_add("Количество товаров не может быть меньше 1");
      return false;
    }

    counter.val(oldVal - 1);
    counter.trigger('change', {
      type: 'down'
    });
  });
  $('.cart-counter').on('change', function (e, param) {
    var key = $(this).data('key');
    var method = param.type == 'up' ? 'up' : 'down';
    var parent = $(this).parents('tr');
    var item_subtotal = parent.find('.cart-item-total');
    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'up_down_cart',
        method: method,
        key: key
      },
      beforeSend: function beforeSend() {
        $('.cart-loading').addClass('loading-show');
      },
      success: function success(response) {
        var result = JSON.parse(response);
        $('#cart, #cart_mobile').text(result.count);
        $('.cart-total-subtotal span').html(result.subtotal);
        $('.cart-subtotal').html(result.subtotal);
        $('.cart-total-sale span').html(result.sale);
        $('.cart-total-sum span').html(result.total);
        $('.cart-loading').removeClass('loading-show');
        item_subtotal.html(result.item_subtotal);
      }
    });
  }); // Применение купона

  $('.btn-coupon').click(function (e) {
    e.preventDefault();
    var input_coupon = $('#coupon');
    var coupon = input_coupon.val().trim();

    if (!coupon) {
      input_coupon.addClass('error-input');
      notification_add('Сначала введите код купона');
      return false;
    }

    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'add_coupon',
        coupon: coupon
      },
      beforeSend: function beforeSend() {
        $('.cart-loading').addClass('loading-show');
      },
      success: function success(response) {
        var result = JSON.parse(response);
        $('.cart-loading').removeClass('loading-show');

        if (result.error.code) {
          input_coupon.addClass('error-input');
          notification_add(result.error.message);
        } else {
          $('.cart-total-my-coupon span').text(result.cart.coupon);
          $('.cart-total-sale span').html(result.cart.sale);
          $('.cart-total-sum span').html(result.cart.total);
          notification_add('Купон применен');
        }
      }
    });
  });
  $('#coupon').on('input', function () {
    $(this).removeClass('error-input');
  }); //Удаляем купон

  $('.cart-coupon-remove').click(function () {
    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'remove_coupon'
      },
      beforeSend: function beforeSend() {
        $('.cart-loading').addClass('loading-show');
      },
      success: function success(response) {
        var result = JSON.parse(response);
        $(this).removeClass('error-input');
        $('.cart-loading').removeClass('loading-show');
        $('.cart-total-my-coupon span').text('нет');
        $('.cart-total-sale span').html(result.cart.sale);
        $('.cart-total-sum span').html(result.cart.total);
        $('#coupon').val('');
        notification_add('Купон удален');
      }
    });
  }); //Удаляем товар из корзины

  $('.item-remove').click(function () {
    var key = $(this).data('key');
    var parent = $(this).parents('tr');
    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'cart_item_remove',
        key: key
      },
      beforeSend: function beforeSend() {
        $('.cart-loading').addClass('loading-show');
      },
      success: function success(response) {
        var result = JSON.parse(response);
        $('.cart-loading').removeClass('loading-show');
        $('#cart, #cart_mobile').text(result.cart.count);
        $('.cart-total-subtotal span').html(result.cart.subtotal);
        $('.cart-subtotal').html(result.cart.subtotal);
        $('.cart-total-sale span').html(result.cart.sale);
        $('.cart-total-sum span').html(result.cart.total);
        notification_add('Товар удален из корзины');
        parent.remove();
      }
    });
  }); // Отправляем данные заказа

  var name_input = {
    names: 'имя',
    email: 'адрес электронной почты',
    telephone: 'номер телефона'
  };
  $('.send-order').click(function (e) {
    e.preventDefault();
    var errors = validateOrder();
    if (errors.length) return false;
    var name = $('#names').val();
    var last_name = $('#last-name').val();
    var email = $('#email').val();
    var telephone = $('#telephone').val();
    var address = $('input[name="address"]').val();
    var comment = $('#comment').val();
    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'send_order',
        name: name,
        last_name: last_name,
        email: email,
        telephone: telephone,
        address: address,
        comment: comment
      },
      beforeSend: function beforeSend() {
        $('.checkout-loading').addClass('loading-show');
      },
      success: function success(response) {
        var result = JSON.parse(response); //Если ошибка в отправленных данных возвращаем ошибку, иначе продолжаем оформление

        if (result.type == 'error') {
          $('.checkout-loading').removeClass('loading-show');
          result.errors.forEach(function (value) {
            var message = "Поле ";
            message += value.field;
            message += value.error == 1 ? ' является обязательным' : ' неправильного формата';
            notification_add(message);
          });
        } else {
          var order = result.order_number;
          window.location.href = "/order-complete/?order=" + order;
        }
      }
    });
  }); //Убираем красную рамку при вводу

  $('.form-wrapper input').on('change', function () {
    $(this).removeClass('error-input');
  }); //Проверяем обязателные поля

  function validateOrder() {
    $('.form-wrapper input').removeClass('error-input');
    var errors = [];
    $('input.require').each(function (index, item) {
      if (!$(item).val().trim()) {
        var name = name_input[$(item).attr('id')];
        $(item).addClass('error-input');
        errors.push(name);
      }
    });

    if (errors.length) {
      var message = 'Поля ' + errors.join(', ') + ' являются обязательными';
      notification_add(message);
    }

    return errors;
  } // Добавление уведомлений


  function notification_add(message) {
    var item = '<div class="notification-item">';
    item += '<div class="notification-message">' + message + '</div>';
    item += '</div>';
    $('.notification-item').each(function (index, item) {
      var top = (index + 1) * 50 + 20;
      $(item).css('top', top + 'px');
    });
    $('.notification-list').prepend(item);
    setTimeout(function () {
      $('.notification-item').first().addClass('notification-show');
    }, 300);
  } // Табы на главной странице


  var popularBlock = $('#popular');
  var newBlock = $('#new');
  newBlock.hide();
  $('.tabs-product a').click(function (e) {
    e.preventDefault();
    $('.tabs-product-active').removeClass('tabs-product-active');
    $(this).addClass('tabs-product-active');
    var blockId = $(this).attr('href');
    popularBlock.hide();
    newBlock.hide();
    $(blockId).show();
  }); // Кнопка поиска

  var searchButton = $('.openSearch');
  var searchBlock = $('.search-row');
  searchButton.click(function (e) {
    e.preventDefault();
    $(this).children('i').toggleClass('la-search');
    $(this).children('i').toggleClass('la-times');
    searchBlock.toggleClass('search-show');
    searchBlock.find('input').val('').focus();
  });
});