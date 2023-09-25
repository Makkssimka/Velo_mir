jQuery(document).ready(function ($) {
  const fields = {
    name: 'имя',
    email: 'email',
    phone: 'телефон'
  }

  $('.phone-mask').mask('+7 (999) 999-99-99');

  $(document).ready(() => {
    initMenu();
    initSlider();
    initCart();
    initToasts();
    initSelect();
    initFilter();
    initModal();
    initSubMenu();
    initMobileMenu();
    initSearch();
    initHeaderItems();
    initCartManipulation();
  });

  /**
   * Инициализация карты
   */
  function initCart() {
    const btn = $('#send-order');

    /**
     * Обрабатываем событие
     * отправки формы
     */
    btn.click(function (e) {
      e.preventDefault();

      if (validate($(this)).count) return;

      sendCart($(this));
    })
  }

  /**
   * Функция отправки формы заказа
   * @param button
   */
  function sendCart(button) {
    const form = button.parents('[data-role="form"]');
    const fields = {};

    form.serializeArray().forEach(item => {
      fields[item.name] = item.value;
    });

    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'send_order',
        ...fields
      },
      beforeSend: function () {
        $('.grid-cart-order').addClass('inactive');
      },
      success: function (response) {
        let result = JSON.parse(response);
        let order = result.order_number;

        window.location.href = "/order-complete/?order=" + order;
      }
    });
  }

  /**
   * Инициализация фильтра
   */
  function initFilter() {

    /**
     * Обработка свертывания/развертывания
     * списка фильтров
     */
    $('.filter__option').each(function () {
      const elements = $(this).find('.filter__item');
      const button = $(this).find('.filter__button');
      const parent = $(this);

      if (elements.length > 3) {
        $(this).addClass('filter__option_wrap');
        button.addClass('filter__button_visible');
      }

      /**
       * Обработка клика по кнопке
       * свернуть/развернуть
       */
      button.find('.link').click(function (e) {
        e.preventDefault();

        if (parent.hasClass('filter__option_unwrap')) {
          parent.removeClass('filter__option_unwrap');
          $(this).text('Показать все');
        } else {
          parent.addClass('filter__option_unwrap');
          $(this).text('Скрыть');
        }
      })
    });

    /**
     * Инициализация слайдера цены
     */
    const priceFrom = $('#priceFrom');
    const priceTo = $('#priceTo');

    $('.filter__slider').ionRangeSlider(
      {
        skin: 'round',
        hide_min_max: true,
        hide_from_to: true,
        /**
         * Отслеживаем событие изменения слайдера
         * @param data
         */
        onChange: function (data) {
          changeFromToInput(data.from, data.to);
        }
      }
    );

    /**
     * Переменная слайдера
     */
    const priceSlider = $(".filter__slider").data("ionRangeSlider");

    /**
     * Отслеживаем событие изменения
     * полей ввода для прайса
     */
    $('.filter__input .input').on('input', function () {
      changeFromToSlider(priceFrom.val(), priceTo.val());
    })

    function changeFromToInput(from, to) {
      priceFrom.val(from);
      priceTo.val(to);
    }

    function changeFromToSlider(from, to) {
      priceSlider.update({
        from: Number(from),
        to: Number(to),
      })
    }

    $('.filter__show').click(function () {
      $('.filter').addClass('filter_visible');
    })

    $('.filter__close').click(function () {
      $('.filter').removeClass('filter_visible');
    })
  }

  /**
   * Инициализация селектора сортировки
   */
  function initSelect() {
    const elValue = $('.select__item_select');
    const elField = $('.select__result');

    elField.text(elValue.text());

    /**
     * Обработка события выбора сортировки
     */
    $('.select__item').click(function () {
      elField.text($(this).text());
      const value = $(this).data('value');

      const select = $(this).parents('.select');

      switch (select.attr('id')) {
        case 'search_sort':
          searchSort(value);
          break;
      }
    });

    /**
     * Обработка событий клика по элементу сортировки
     */
    $('.select').click(function (e) {
      e.stopPropagation();
      $(this).toggleClass('select__active');
    });

    $(document).click(function () {
      $('.select').removeClass('select__active');
    })
  }

  function searchSort(value) {
    let url_params = window.location.search.substring(1);
    url_params = new URLSearchParams(url_params);
    url_params.set('sort', value);
    url_params["delete"]('page_count');

    const link = url_params.toString();
    window.location.href = window.location.pathname + '?' + link;
  }

  /**
   * Pseudo-random string generator
   * Default: return a random alpha-numeric string
   *
   * @param {Number} len
   * @param {String} an
   * @return {String}
   */
  function randomString(len, an) {
    an = an && an.toLowerCase();
    let str = "",
      i = 0,
      min = an === "a" ? 10 : 0,
      max = an === "n" ? 10 : 62;
    for (; i++ < len;) {
      let r = Math.random() * (max - min) + min << 0;
      str += String.fromCharCode(r += r > 9 ? r < 36 ? 55 : 61 : 48);
    }
    return str;
  }

  /**
   * Инициализация меню
   * @param activeItem
   */
  function initMenu() {
    $(".main-menu__list").owlCarousel({
      dots: true,
      mouseDrag: false,
      margin: 5,
      nav: true,
      navText: [
        '<img src="/wp-content/themes/velo-shop-new/assets/images/app/menu-prev.svg" />',
        '<img src="/wp-content/themes/velo-shop-new/assets/images/app/menu-next.svg" />',
      ],
      responsive: {
        0: {
          items: 2,
          nav: false,
        },
        768: {
          items: 6,
          nav: true,
        }

      }
    });

    const activeItem = $('[data-default]').data('default');
    renderActive(activeItem);

    /**
     * Отображаем первичный блок с категорией велосипеды
     */
    const loaderElem = $('[data-catalog="loader"]');

    if (loaderElem.length) {
      loadCatalog($('[data-child]').first().data('id'));
    }

    /**
     * Отрисовка выбранного пункта меню
     * @param activeItem
     */
    function renderActive(activeItem) {
      $('.main-menu__item_active').removeClass('main-menu__item_active');
      $(`.main-menu__item:contains("${activeItem}")`).addClass('main-menu__item_active');
    }

    /**
     * Обработка клика по пункту меню
     */
    $('.main-menu__item').click(function (e) {
      const child = $(this).data('child');
      if (!child || !loaderElem.length) return true;

      e.preventDefault();

      renderActive($(this).text());
      loadCatalog($(this).data('id'));
    });
  }

  /**
   * Функция ajax загрузки категории
   * @param id
   */
  function loadCatalog(id) {
    const loader = $('.catalog__loader');
    const headMenu = $('[data-catalog="head"]');

    loader.addClass('loader_show');

    const data = {
      id: id,
      action: 'catalog_ajax',
    }

    $.post(window.wp_data.ajax_url, data)
      .success(function (res) {
        const result = JSON.parse(res);

        headMenu.text(result.category.name);
        renderCatalog(result.children);

        loader.removeClass('loader_show');
      })
  }

  /**
   * Функция отрисовки каталога
   * @param list
   */
  function renderCatalog(list) {
    const listMenu = $('[data-catalog="list"]');
    listMenu.html('');

    list.forEach(function (item) {
      const link = $(document.createElement('a'));
      link.addClass('catalog-category__item');
      link.attr('href', item.link);

      const name = $(document.createElement('span'));
      name.text(item.name);

      const image = $(document.createElement('div'));
      image.addClass('catalog-category__bg');
      image.css('background-image', 'url(' + item.thumbnail + ')');

      link.append(name);
      link.append(image);
      listMenu.append(link);
    })
  }

  /**
   * Инициализация мобильного меню
   */
  function initMobileMenu() {
    /**
     * Перебираем пункты меню и
     * ищем элементы с вложенным меню
     */
    $('.mobile-menu__list > li > a').each(function (idx, item) {
      const parent = $(item).parent('li');

      if (parent.find('ul').length) {
        parent.addClass('mobile-menu__item_sub');

        /**
         * Обрабатываем клик по элементу
         * с вложенным меню
         */
        $(item).click(function (event) {
          event.preventDefault();
          openMobileMenu(parent);
        });
      }
    });

    /**
     * Открываем мобильное меню
     */
    $('[data-target="mobile_menu"]').click(function (event) {
      if (!window.matchMedia('(max-width: 768px)').matches) return;

      event.preventDefault();
      $('.mobile-menu').addClass('mobile-menu_open');
    });

    /**
     * Закрываем мобильное меню
     */
    $('.mobile-menu__close').click(function () {
      $('.mobile-menu').removeClass('mobile-menu_open');
    });
  }

  /**
   * Функция раскрытия/закрытия подменю
   * @param elem
   */
  function openMobileMenu(elem) {
    elem.toggleClass('mobile-menu__item_open');

    const subMenu = elem.find('ul');
    subMenu.slideToggle();
  }

  /**
   * Инициализация модального окна
   */
  function initModal() {
    /**
     * Открытие модального окна
     */
    $('[data-modal]').click(function (event) {
      event.preventDefault();

      const id = '#' + $(this).data('modal');
      $(id).addClass('modal_show');
    });

    /**
     * Закрытие модального окна
     */
    $('.modal__close').click(function () {
      const modal = $(this).parents('.modal');

      modal.removeClass('modal_show');
      modal.find('input[type="text"]').val('');
    });

    /**
     * Отправка модальных сообщений
     */
    $('.modal__submit').click(function (event) {
      event.preventDefault();

      if (validate($(this)).count) return;

      sendCall($(this));
    })
  }

  /**
   * Функция отправки обратного вызова
   * @param button
   */
  function sendCall(button) {
    const form = button.parents('[data-role="form"]');
    const fields = {};

    form.serializeArray().forEach(item => {
      fields[item.name] = item.value;
    });

    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'call_form_add_request',
        ...fields
      },
      beforeSend: function () {
        form.addClass('inactive');
      },
      success: function (response) {
        $('.modal').addClass('modal_success');
      }
    });
  }

  /**
   * Инициализация слайдера
   * и просмотра изображения
   */
  function initSlider() {
    const slider = $(".gallery__slider");

    /**
     * Обработка инициализации галереи
     */
    slider.on('initialized.owl.carousel', function (event) {
      renderCounter(event.item.index + 1, event.item.count);
    });

    slider.owlCarousel({
      dots: false,
      items: 1,
      mouseDrag: true,
      nav: true,
      navText: [
        '<img src="/wp-content/themes/velo-shop-new/assets/images/icons/round-left.svg" />',
        '<img src="/wp-content/themes/velo-shop-new/assets/images/icons/round-right.svg" />',
      ]
    });

    /**
     * Обработка изменения галереи
     */
    slider.on('changed.owl.carousel', function (event) {
      renderCounter(event.item.index + 1, event.item.count);

      const activePreview = $(`.preview__item[data-index="${event.item.index}"]`);
      renderActivePreview(activePreview);
    });

    /**
     *  Обработка клика по
     *  превью элементу
     */
    $('.preview__item').click(function (event) {
      event.preventDefault();

      renderActivePreview($(this));

      const index = $(this).data('index');
      slider.trigger('to.owl.carousel', [index]);
    });
  }

  /**
   * Отрисовка счетчика количества изображений
   * @param step - текущий шаг
   * @param all - общее количество шагов
   */
  function renderCounter(step, all) {
    $('.gallery__counter_step').text(step);
    $('.gallery__counter_all').text(all);
  }

  /**
   * Отрисовка активного элемента превью
   * @param elem
   */
  function renderActivePreview(elem) {
    $('.preview__item_active').removeClass('preview__item_active');
    elem.addClass('preview__item_active');
  }


  /**
   * Инициализация верхнего подменю
   */
  function initSubMenu() {
    /**
     * Закрытие подменю
     */
    $('.top-submenu__close').click(function () {
      $('.top-submenu').removeClass('top-submenu_show');
    });

    /**
     * Открытие подменю
     */
    $('[data-target="top-submenu"]').click(function () {
      $('.top-submenu').addClass('top-submenu_show');
    })
  }

  let toastsElem = null;

  /**
   * Инициализация toasts
   */
  function initToasts() {
    toastsElem = $('.toasts');
  }

  /**
   * Функция добавления toast
   * @param message
   */
  function addToast(message) {
    const id = randomString(7);

    const toast = $(document.createElement('div'));
    toast.attr('id', id);
    toast.addClass('toast');
    toast.addClass('toasts_visible');
    toast.text(message);

    toastsElem.append(toast);
    removeToast(id);
  }

  /**
   * Функция удаления toast
   * @param id
   */
  function removeToast(id) {
    const toast = $('#' + id);

    setTimeout(function () {
      toast.remove();
    }, 5100);
  }

  /**
   * Обработка применения фильтра
   */
  $('#filter_submit').click(function (event) {
    event.preventDefault();
    let list_checkbox = $('.filter input[type="checkbox"]');
    let value_array = {};
    const category = $(this).data('category');

    list_checkbox.each(function (index, item) {
      if ($(item).is(":checked")) {
        console.log(item);

        let key = $(item).attr('name');
        let value = $(item).val();

        if (key in value_array) {
          value_array[key].push(value);
        } else {
          value_array[key] = new Array(value);
        }
      }
    });

    let price = [
      $('#priceFrom').val().replace(/[^\d.\-]/g, ''),
      $('#priceTo').val().replace(/[^\d.\-]/g, '')
    ];

    let link = '?session_filter';
    for (let key in value_array) {
      link += '&' + key + '=' + value_array[key].join(',');
    }

    link += '&price=' + price.join(',');
    link += '&category=' + category;
    window.location.href = window.location.pathname + link;
  });


  /**
   * Функция валидации полей формы
   * @param button
   * @param visible
   * @return {{}}
   */
  function validate(button, visible = true) {
    const form = button.parents('[data-role="form"]');
    const errors = {
      count: 0
    };

    /**
     * Перебираем поля формы и проверяем правила
     */
    const fields = form.find('[data-valid]');
    fields.each(function () {
      const rules = $(this).data('valid').split(',');
      const val = $(this).val();
      const field = $(this).attr('name');


      rules.forEach(function (item) {
        const result = window[item](val, field);

        if (result) {
          errors[field] = errors[field] ? errors[field].push(result) : [result];
          errors.count++;
        }
      })
    })

    /**
     * Удаляем стили ошибки при вводе
     */
    fields.on('input', function () {
      $(this).removeClass('input-form_error');
      $(this).prev('.input-form__message').text('');
    })

    /**
     * Показываем сообщение с ошибкой
     */
    if (visible) visibleErrors(form, errors);

    return errors;
  }

  /**
   * Инициализация поиска
   */
  function initSearch() {
    // Ajax поиск
    const searchInput = $('.search-input');
    const searchEl = $('.search-result-ajax');
    const searchUl = $('.search-result-ajax ul');
    const searchAllLinks = $('.top-header__icon, .search-all a');
    const searchAll = $('.search-all');
    let searchTimer = null;


    searchInput.on('input', function () {
      const search = $(this).val();

      searchAll.hide();

      searchAllLinks.attr('href', '/search?search=' + search);

      searchUl.html('<li>Идет поиск...</li>');

      if (search.length > 3) {
        clearTimeout(searchTimer);
        searchEl.show();
        searchTimer = setTimeout(function () {
          searchEvent(search);
        }, 500);
      } else {
        searchUl.html('');
        searchEl.hide();
        clearTimeout(searchTimer);
      }
    });

    /**
     * Функция обработки события поиска
     * @param search
     */
    function searchEvent(search) {
      $.ajax({
        type: 'POST',
        url: window.wp_data.ajax_url,
        data: {
          action: 'search_ajax',
          search: search
        },
        success: function (response) {
          const res = JSON.parse(response);
          searchUl.html('');

          if (res.search_result.length) {
            renderSearchUl(res.search_result);

            if (res.search_result.length >= 5) {
              searchAll.show()
            }

          } else {
            searchUl.html('<li>Ничего не найдено...</li>');
          }
        }
      });
    }

    /**
     * Функция отрисовки списка найденных элементов
     * @param items
     */
    function renderSearchUl(items) {
      items.forEach(item => {
        const li = document.createElement('li');

        const photoEl = document.createElement('div');
        photoEl.classList.add('search-ajax-image');
        const photoImg = document.createElement('img');
        photoImg.src = item.image;
        photoEl.appendChild(photoImg);

        const titleEl = document.createElement('div')
        titleEl.classList.add('search-ajax-link');
        const titleLink = document.createElement('a');
        titleLink.href = item.link;
        titleLink.target = '_blank'
        titleLink.innerHTML = item.title;
        titleEl.appendChild(titleLink);
        const skuElem = document.createElement('small');
        skuElem.innerHTML = item.sku;
        titleEl.appendChild(skuElem);

        const priceEl = document.createElement('div');
        priceEl.classList.add('search-ajax-price');
        priceEl.innerHTML = item.price;

        li.appendChild(photoEl);
        li.appendChild(titleEl);
        li.appendChild(priceEl);

        searchUl.append(li);
      });
    }
  }

  /**
   *  Инициализация верхнего меню
   *  сравнения, добавления в корзину и т.д.
   */
  function initHeaderItems() {
    renderHeaderItems();

    $('[data-favorite]').click(function (event) {
      event.preventDefault();

      changeFavorites($(this));
    });

    $('[data-compare]').click(function (event) {
      event.preventDefault();

      changeCompare($(this));
    });
  }

  /**
   * Функция добавления/удаления из избранного
   * @param button
   */
  function changeFavorites(button) {
    const id = button.attr('data-favorite');

    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'add_favorites',
        id: id
      },
      beforeSend: function() {
        button.addClass('inactive');
      },
      success: function () {
        let count = Number($('[data-counter="favorites"]').attr('data-count'));
        addHeaderItems('favorites', button.hasClass('selected_orange') ? --count : ++count);

        button.removeClass('inactive');
        button.hasClass('selected_orange') ? button.removeClass('selected_orange') : button.addClass('selected_orange')

        const url = new URL(window.location.href);
        if (url.pathname === '/favorites/') {
          window.location.reload();
        }
      }
    });
  }

  /**
   * Функция добавления/удаления из сравнения
   * @param button
   */
  function changeCompare(button) {
    const id = button.attr('data-compare');

    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'add_compare',
        id: id
      },
      beforeSend: function() {
        button.addClass('inactive');
      },
      success: function () {
        let count = Number($('[data-counter="compare"]').attr('data-count'));
        addHeaderItems('compare', button.hasClass('selected_blue') ? --count : ++count);

        button.removeClass('inactive');
        button.hasClass('selected_blue') ? button.removeClass('selected_blue') : button.addClass('selected_blue')

        const url = new URL(window.location.href);
        if (url.pathname === '/compare/') {
          window.location.reload();
        }
      }
    });
  }

  /**
   * Функция изменения счетчика элементов
   * @param type
   * @param count
   */
  function addHeaderItems(type = 'cart', count) {
    const item = $(`[data-counter="${type}"]`);
    item.attr('data-count', count);
    renderHeaderItems();
  }

  /**
   * Функция перерисовки счетчик элементов
   */
  function renderHeaderItems() {
    const counters = $('[data-counter]');

    counters.each(function () {
      const item = $(this);
      const count = Number($(this).attr('data-count'));

      if (count) {
        $(this).addClass('top-header__counter_visible');
        $(this).text(count);
      } else {
        $(this).removeClass('top-header__counter_visible');
      }
    })
  }

  /**
   *  Функция инициализации изменения карты
   */
  function initCartManipulation() {
    $('[data-add-cart]').click(function (event) {
      event.preventDefault();
      addToCart($(this));
    })

    $('[data-cart-counter]').click(function (event) {
      event.preventDefault();

      const type = $(this).attr('data-cart-counter');
      const key = $(this).attr('data-key');
      cartCounterChange(type, key, $(this));
    });

    $('[data-cart-remove]').click(function (event) {
      event.preventDefault();

      const key = $(this).attr('data-key');
      cartRemove(key, $(this));
    })

    $('[data-send-coupon]').click(function (event) {
      event.preventDefault();

      const coupon = $('[data-coupon]').val();
      setCoupon(coupon, $(this));
    });

    $('[data-remove-coupon]').click(function (event) {
      event.preventDefault();

      removeCoupon($(this));
    })
  }

  /**
   * Функция изменения количества товаров в корзине
   * @param type
   * @param key
   * @param elem
   */
  function cartCounterChange(type = 'up', key = '', elem) {
    const parent = elem.parents('[data-cart]');

    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'up_down_cart',
        method: type,
        key: key
      },
      beforeSend: function () {
        parent.addClass('grid-cart-main__inactive');
      },
      success: function () {
        location.reload();
      }
    });
  }

  /**
   * Функция удаления элемента корзины
   * @param key
   * @param elem
   */
  function cartRemove(key = '', elem) {
    const parent = elem.parents('[data-cart]');

    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'cart_item_remove',
        key: key
      },
      beforeSend: function () {
        parent.addClass('grid-cart-main__inactive');
      },
      success: function (response) {
        location.reload();
      }
    });
  }

  /**
   * Функция добавления купона
   * @param coupon
   * @param elem
   */
  function setCoupon(coupon, elem) {
    const parent = elem.parents('[data-cart]');

    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'add_coupon',
        coupon: coupon
      },
      beforeSend: function () {
        parent.addClass('grid-cart-main__inactive');
      },
      success: function (response) {
        location.reload();
      }
    });
  }

  /**
   * Функция удаление купона
   * @param elem
   */
  function removeCoupon(elem) {
    const parent = elem.parents('[data-cart]');

    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'remove_coupon'
      },
      beforeSend: function () {
        parent.addClass('grid-cart-main__inactive');
      },
      success: function (response) {
        location.reload();
      }
    });
  }

  /**
   * Функция добавления товара в корзину
   * @param elem
   */
  function addToCart(elem) {
    const id = elem.attr('data-product');

    $.ajax({
      type: 'POST',
      url: window.wp_data.ajax_url,
      data: {
        action: 'add_to_cart',
        id: id
      },
      beforeSend: function () {
        elem.addClass('catalog-item__button_inactive');
      },
      success: function (response) {
        const count = JSON.parse(response);
        addHeaderItems('cart', count);

        const text = elem.find('span');
        if (text) text.text('В корзину')

        elem.removeClass('catalog-item__button_inactive');
        elem.addClass('catalog-item__button_active');
        elem.unbind('click');
      }
    });
  }
});

/**
 * Функция вывода ошибки
 * @param form
 * @param errors
 */
function visibleErrors(form, errors) {
  for (const field in errors) {
    const input = form.find(`[name="${field}"]`);
    const message = input.prev('.input-form__message');

    input.addClass('input-form_error');
    message.text(errors[field][0]);
  }
}

/**
 * Правило валидации - обязательное поле
 * @param value
 * @param field
 * @return {string}
 */
function required(value, field) {
  if (value.trim()) return '';

  const name = fieldsName[field];
  return errorMessage.required.replace(':field', name);
}

/**
 * Названия полей
 * @type {{phone: string}}
 */
const fieldsName = {
  phone: 'номер телефона',
  name: 'имя',
  email: 'электронная почта'
}

/**
 * Строки с ошибками
 * @type {{required: string}}
 */
const errorMessage = {
  required: 'Поле :field обязательно',
}