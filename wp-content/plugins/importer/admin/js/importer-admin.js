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
	const step = 10;
	let importTimer = 0;
	let productArray = [];
	let stop = false;
	let countProduct = 0;
	let stepCount = 0;

	// Обработка кнопок
	startProductBtn.click(function () {
		stop = false;

		progressMsg.removeClass('display-none');
		$(this).addClass('disabled');
		stopProductBtn.removeClass('disabled');

		unzip();
		//productCount();
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
			action: 'importer_unzip'
		};

		$.post(ajaxurl, sendData, function (response) {
			const result = JSON.parse(response);
			const status = Number(result.status);

			if (status === 2) {
				$('#time-unzip').text(timer.getTimeResult());
				$('.status-unzip').text(getStatus(status));

				productData();
			}
		});
	}

	// Получение данных продукта
	function productData() {
		const timer = new Timer();
		$('.status-data').text(getStatus(1));
		setStatusMessage('получение данных...');

		let sendData = {
			action: 'importer_data'
		};

		$.post(ajaxurl, sendData, function (response) {
			const result = JSON.parse(response);
			const status = Number(result.status);
			productArray = result.data;
			countProduct = result.data.length;

			if (status === 2) {
				$('#time-data').text(timer.getTimeResult());
				$('.status-data').text(getStatus(status));

				importTimer = new Timer();
				productImport();
			}

		});
	}

	// Импорт полученных товаров
	function productImport() {
		$('.status-migrate').text(getStatus(1));
		setStatusMessage(`импортировано ${stepCount} из ${countProduct}`);

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

				cleanDataFolders();
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

		if (dataStep) {
			$.post(ajaxurl, sendData, function () {
				progressBarCat.attr('value', stepCat);
				stepCatElem.text(stepCat);
				sendStepCatalog();
			});
		} else {
			location.reload();
		}
	}

});

})( jQuery );
