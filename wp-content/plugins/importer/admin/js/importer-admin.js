(function( $ ) {
'use strict';

$(document).ready(function () {
	$("#sku-generator").click(function (e) {
		e.preventDefault();
		let btn = $(this).addClass("button-disabled");
		btn.addClass("button-disabled");
		$.post(ajaxurl, {action: "sku_generated"}, function (data) {
			addTr("Добавлено артикулов",data);
			btn.removeClass("button-disabled");
		});
	});

	function addTr(msg,count) {
		let table = $("#sku-table");
		let tr = `<tr>
				<td class="first-td-importer">
					<span class="importer-title">${ msg }</span>
				</td>
				<td>
					<span class="importer-title">${ count }</span>
				</td>
			</tr>`;
		table.append(tr);
	}

	// Классы импорта
	class Timer {
		timer = 0;

		constructor() {
			this.timer = new Date();
		}

		getTimeResult() {
			return ((new Date() - this.timer) / 1000).toFixed(2) + ' сек';
		}
	}

	// Импортрование продуктов
	const startProductBtn = $('#start-import');
	const stopProductBtn = $('#stop-import');
	const progressMsg = $('.progress-message');
	let globalCounter = 1;
	let globalSteps = 0;
	const step = 10;
	let importTimer = 0;
	let importCategoryTimer = 0;
	let productArray = [];
	let categoryArray = [];
	let stop = false;
	let countProduct = 0;
	let countCategory = 0;
	let stepCount = 0;
	let stepCategoryCount = 0;

	// Обработка кнопки импорта
	startProductBtn.click(function () {
		stop = false;

		progressMsg.removeClass('display-none');
		$(this).addClass('disabled');
		stopProductBtn.removeClass('disabled');

		unzip();
	});

	stopProductBtn.click(function () {
		stop = true;
	});

	// Функции импорта продуктов

	// Функция разархивирования
	function unzip() {
		const timer = new Timer();
		$('.status-unzip').text(getStatus(1));
		setStatusMessage('идет распаковка...');

		let sendData = {
			action: 'importer_unzip',
			counter: globalCounter
		};

		$.post(ajaxurl, sendData, function (response) {
			const result = JSON.parse(response);
			const status = Number(result.status);
			globalSteps = result.data;

			if (status === 2) {
				$('#time-unzip').text(timer.getTimeResult());
				$('.status-unzip').text(getStatus(status));

				categoryData();
			}
		});
	}

	// Получение данных категории
	function categoryData() {
		const timer = new Timer();
		$('.status-category-data').text(getStatus(1));
		setStatusMessage('получение данных...');

		let sendData = {
			action: 'importer_category_data',
			counter: globalCounter
		};

		$.post(ajaxurl, sendData, function (response) {
			const result = JSON.parse(response);
			const status = Number(result.status);
			categoryArray = result.data;
			countCategory = result.data.length;

			if (status === 2) {
				$('#time-category-data').text(timer.getTimeResult());
				$('.status-category-data').text(getStatus(status));

				importCategoryTimer = new Timer();
				categoryImport();
			}
		});
	}

	// Импорт полученных категорий
	function categoryImport() {
		$('.status-category').text(getStatus(1));
		setStatusMessage(`импортировано ${stepCategoryCount} из ${countCategory}`);

		let sendData = {
			categories: categoryArray.splice(0, step),
			action: 'importer_category_migrate'
		};

		$.post(ajaxurl, sendData, function (response) {
			const result = JSON.parse(response);
			const status = Number(result.status);
			const counter = Number(result.data);
			stepCategoryCount += counter;

			if (stepCategoryCount < countCategory && !stop) {
				categoryImport();
			} else {
				$('#time-category').text(importCategoryTimer.getTimeResult());
				$('.status-category').text(getStatus(status));

				productData();
			}
		});
	}

	// Получение данных продукта
	function productData(counter = 0) {
		const timer = new Timer();
		$('.status-data').text(getStatus(1));
		setStatusMessage('получение данных...');

		let sendData = {
			action: 'importer_data',
			counter: globalCounter
		};

		$.post(ajaxurl, sendData, function (response) {
			const result = JSON.parse(response);
			const status = Number(result.status);
			const data = result.data;

			if (status === 2) {
				$('#time-data').text(timer.getTimeResult());
				$('.status-data').text(getStatus(status));

				productArray = data;
				countProduct = productArray.length;

				importTimer = new Timer();
				productImport();
			}
		});
	}

	// Импорт полученных товаров
	function productImport() {
		$('.status-migrate').text(getStatus(1));
		setStatusMessage(`импортировано ${stepCount} из ${countProduct}, шаг ${globalCounter} из ${globalSteps}`);

		let sendData = {
			products: productArray.splice(0, step),
			action: 'importer_migrate'
		};

		$.post(ajaxurl, sendData, function (response) {
			const result = JSON.parse(response);
			const status = Number(result.status);
			const counter = Number(result.data);
			stepCount += counter;

			if (stepCount < countProduct && !stop) {
				productImport();
			} else {
					$('#time-migrate').text(importTimer.getTimeResult());
					$('.status-migrate').text(getStatus(status));

					globalCounter++;
					stepCount = 0;

					console.log(globalCounter);

					if (globalCounter > globalSteps) {
						cleanDataFolders();
					} else {
						productData();
					}
			}
		});
	}

	// Функция очистки папок после импорта
	function cleanDataFolders() {
		const timer = new Timer();
		$('.status-clean').text(getStatus(1));
		setStatusMessage('идет удаление...');

		let sendData = {
			action: 'importer_clean'
		};

		$.post(ajaxurl, sendData, function (response) {
			const result = JSON.parse(response);
			const status = Number(result.status);

			if (status === 2) {
				$('#time-clean').text(timer.getTimeResult());
				$('.status-clean').text(getStatus(status));

				logsWrite();
			}
		});
	}

	// Функция записи логов
	function logsWrite() {
		const timer = new Timer();
		$('.status-logs').text(getStatus(1));
		setStatusMessage('запись логов...');

		let sendData = {
			action: 'importer_logs',
			counter: stepCount
		};

		$.post(ajaxurl, sendData, function (response) {
			const result = JSON.parse(response);
			const status = Number(result.status);

			if (status === 2) {
				$('#time-logs').text(timer.getTimeResult());
				$('.status-logs').text(getStatus(status));

				stepCount = 0;

				startProductBtn.removeClass('disabled');
				stopProductBtn.addClass('disabled');
				progressMsg.addClass('display-none');
			}
		});
	}

	// Вспомогательные функции импорта
	function getStatus(code) {
		let result = '';
		switch (code) {
			case 1 :
				result = "обработка данных";
				break;
			case 2 :
				result = "выполнено";
				break;
			case 99 :
				result = "ошибка";
		}

		return result;
	}

	function setStatusMessage(message) {
		$('.progress-message strong').text(message);
	}



	// Очистка товаров
	const startCleanBtn = $('#start-clean');
	const stopCleanBtn = $('#stop-clean');
	let cleanTimer = '';
	let cleanStepCount = 0;
	let cleanCountProduct = 0
	let siteProductsData = [];
	let importProductsData = [];
	let cleanProductsData = [];

	// Остальные переменные берутся из импорта см. выше

	startCleanBtn.click(function () {
		stop = false;

		progressMsg.removeClass('display-none');
		$(this).addClass('disabled');
		stopCleanBtn.removeClass('disabled');

		unzipClean();
	});

	stopCleanBtn.click(function () {
		stop = true;
	});

	// Функции очистки

	// Функция разархивирования
	function unzipClean() {
		const timer = new Timer();
		$('.status-unzip').text(getStatus(1));
		setStatusMessage('идет распаковка...');

		let sendData = {
			action: 'importer_unzip'
		};

		$.post(ajaxurl, sendData, function (response) {
			const result = JSON.parse(response);
			const status = Number(result.status);

			if (status === 2) {
				$('#time-unzip').text(timer.getTimeResult());
				$('.status-unzip').text(getStatus(status));

				productsData();
			}
		});
	}

	// Получение массива товаров (ид товара => ид 1С) с сайта
	function productsData() {
		const timer = new Timer();
		$('.status-products-data').text(getStatus(1));
		setStatusMessage('Получение данных...');

		let sendData = {
			action: 'importer_products_data'
		};

		$.post(ajaxurl, sendData, function (response) {
			const result = JSON.parse(response);
			const status = Number(result.status);
			siteProductsData = result.data;

			if (status === 2) {
				$('#time-products-data').text(timer.getTimeResult());
				$('.status-products-data').text('найдено товаров: ' + siteProductsData.length);
				importData();
			}
		});
	}

	// Получение массива товаров (ид 1С) с импорта
	function importData() {
		const timer = new Timer();
		$('.status-import-data').text(getStatus(1));
		setStatusMessage('Получение данных...');

		let sendData = {
			action: 'importer_import_data'
		};

		$.post(ajaxurl, sendData, function (response) {
			const result = JSON.parse(response);
			const status = Number(result.status);
			importProductsData = result.data;

			if (status === 2) {
				$('#time-import-data').text(timer.getTimeResult());
				$('.status-import-data').text('найдено товаров: ' + importProductsData.length);
				removeData();
			}
		});
	}

	// Создаем массив с ид которые нужно удалить
	function removeData() {
		const timer = new Timer();
		$('.status-remove-data').text(getStatus(1));
		setStatusMessage('Получение данных...');

		siteProductsData.forEach(value => {
			if(!importProductsData.includes(value.meta_value)) {
				cleanProductsData.push(value.ID);
			}
		})

		$('#time-remove-data').text(timer.getTimeResult());
		$('.status-remove-data').text('найдено товаров: ' + cleanProductsData.length);
		cleanCountProduct = cleanProductsData.length;

		cleanTimer = new Timer();
		cleaner();
	}

	// Удаляем товары
	function cleaner() {
		$('.status-cleaner').text(getStatus(1));
		setStatusMessage(`удалено ${cleanStepCount} из ${cleanCountProduct}`);

		let sendData = {
			products: cleanProductsData.splice(0, step),
			action: 'importer_cleaner'
		};

		$.post(ajaxurl, sendData, function (response) {
			const result = JSON.parse(response);
			const status = Number(result.status);
			const counter = Number(result.data);
			cleanStepCount += counter;

			if (cleanStepCount < cleanCountProduct && !stop) {
				cleaner();
			} else {
				$('#time-cleaner').text(cleanTimer.getTimeResult());
				$('.status-cleaner').text(getStatus(status));

				cleanDataFolders();
			}
		});
	}


	// Импортирование категорий
	let selectList = [];
	const concatBtn = $('.categories-concat');
	const renameBtn = $('.category-rename');
	const importCatBtn = $('#importCat');
	const counterCategories = $('.counter-categories');
	const nameCategoryInput = $('#cat-name');

	$('.category-edit').change(function () {
		selectList = $('.category-edit:checked');

		counterCategories.text(selectList.length);
		btnIsActive();
	});

	function btnIsActive() {
		switch (selectList.length) {
			case 0:
				concatBtn.addClass('disabled');
				renameBtn.addClass('disabled');
				break;
			case 1:
				concatBtn.addClass('disabled');
				renameBtn.removeClass('disabled');
				break;
			default:
				concatBtn.removeClass('disabled');
				renameBtn.addClass('disabled');
				break;
		}
	}

	// Переименование категории
	renameBtn.click(function () {
		const elem = selectList.first();
		const tr = elem.parents('tr');
		tr.find('.category-name').text(nameCategoryInput.val());
	});

	// Объединение категорий
	concatBtn.click(function () {
		let ids = [];

		selectList.each(function (index) {
			if (selectList.length === index + 1) {
				ids.push($(this).val());

				let parent = $(this).parents('tr');
				parent.find('.category-name').text(nameCategoryInput.val());
				parent.find('.category-id').text(ids.join(', '));

				$(this).attr('data-name', nameCategoryInput.val());
				$(this).click();
				$(this).val(ids.join(', '));

				nameCategoryInput.val('');
			} else {
				ids.push($(this).val());
				$(this).parents('tr').remove();
			}
		});
	});

	// Импортирование категорий Ajax
	const progressBarCat = $('.progress-categories progress');
	const stepCatElem = $('#step-categories');
	const stepAllCatElem = $('#all-categories');
	const progressBlockCat = $('.progress-categories');
	const defaultStep = 10;
	let stepCat = 0;
	let dataList = [];

	importCatBtn.click(function (e) {
		e.preventDefault();
		let dataElement = $('.category-edit');

		dataElement.each(function () {
			const data = {
				name: $(this).attr('data-name'),
				id: $(this).val(),
				parent: $(this).attr('data-parent')
			};

			dataList.push(data);
		});


		progressBarCat.attr('max', dataList.length);
		progressBarCat.attr('value', stepCat);
		stepAllCatElem.text(dataList.length);
		progressBlockCat.removeClass('display-none');

		sendStepCatalog();
	});

	function sendStepCatalog() {
		importCatBtn.addClass('disabled');

		let dataStep = dataList.splice(0, defaultStep);
		stepCat = stepCat + dataStep.length;

		let sendData = {
			data: dataStep,
			action: 'importer_categories'
		};

		if (dataStep.length) {
			$.post(ajaxurl, sendData, function () {
				progressBarCat.attr('value', stepCat);
				stepCatElem.text(stepCat);
				sendStepCatalog();
			});
		} else {
			document.location.reload();
		}
	}

});

})( jQuery );
