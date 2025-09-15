$(document).ready(function () {
  const MAX_DOCUMENTS = 4;
  const form = $("#compare-form");
  const documentsContainer = $(".compare-section__selects");
  const addButton = $("#add-document");
  const resetButton = $("#reset-btn");

  function showError(message) {
    $(".message--error").remove();
    const error = $(`
      <div class="message message--error">
        <span class="message__text">${message}</span>
        <button type="button" class="btn-close">x</button>
      </div>
    `);
    $(".compare-section__title").after(error);
    timeoutMessages(2);
  }

  function getSelectedValues() {
    const values = [];
    $('select[name="documents[]"]').each(function () {
      const val = $(this).val();
      if (val !== null && val !== "") {
        values.push(val);
      }
    });
    return values;
  }

  function hasDuplicates(arr) {
    for (let i = 0; i < arr.length; i++) {
      for (let j = i + 1; j < arr.length; j++) {
        if (arr[i] === arr[j]) {
          return true;
        }
      }
    }
    return false;
  }

  function updateSelectOptions() {
    const selectedValues = getSelectedValues();
    $('select[name="documents[]"]').each(function () {
      const currentSelect = $(this);
      const currentValue = currentSelect.val();
      currentSelect.find("option").each(function () {
        const option = $(this);
        const optionValue = option.val();
        if (!optionValue) {
          option.prop("disabled", false);
          return;
        }
        option.prop(
          "disabled",
          optionValue !== currentValue && selectedValues.includes(optionValue)
        );
      });
    });
  }

  function addRemoveButtons() {
    $(
      ".compare-section__select-container--3, .compare-section__select-container--4"
    ).each(function () {
      const container = $(this);
      if (!container.find(".compare-section__remove").length) {
        const removeSpan = $('<span class="compare-section__remove">x</span>');
        container.find("label").append(removeSpan);

        removeSpan.on("click", function () {
          container.remove();
          addButton.show();
          updateSelectOptions();
        });
      }
    });
  }

  function addDocumentField() {
    const currentCount = $(".compare-section__select-container").length;
    if (currentCount >= MAX_DOCUMENTS) {
      addButton.hide();
      return;
    }
    const newSelect = $(".compare-section__select-container").first().clone();
    newSelect.addClass(
      "compare-section__select-container--" + (currentCount + 1)
    );
    newSelect.find("label").text(`Documento ${currentCount + 1}`);
    newSelect.find("select").val("");
    documentsContainer.append(newSelect);
    updateSelectOptions();
    if (currentCount + 1 >= MAX_DOCUMENTS) addButton.hide();

    addRemoveButtons();
  }

  function validateForm() {
    const selected = getSelectedValues();
    if (selected.length < 2) {
      showError("Debes seleccionar al menos 2 documentos");
      return false;
    }
    if (hasDuplicates(selected)) {
      showError("No puedes seleccionar el mismo documento más de una vez");
      return false;
    }
    return true;
  }

  addButton.on("click", addDocumentField);
  documentsContainer.on(
    "change",
    'select[name="documents[]"]',
    updateSelectOptions
  );

  form.on("submit", function (e) {
    if (!validateForm()) {
      e.preventDefault();
    }
  });

  resetButton.on("click", function () {
    $(".message--error").remove();
    $(".compare-section__select-container").slice(2).remove();
    $(".compare-section__select").val("");
    addButton.show();
    $("#export-btn").hide();
    $(".chart-header, .chart-container").parent("section").hide();
    updateSelectOptions();
  });

  updateSelectOptions();
  if ($(".compare-section__select-container").length >= MAX_DOCUMENTS) {
    addButton.hide();
  } else {
    addButton.show();
  }

  addRemoveButtons();

$("#export-btn").on("click", function () {
  const exportArea = document.querySelector(".compare-chart__container");
  html2canvas(exportArea, { scale: 3 }).then(function (canvas) {
    const imgData = canvas.toDataURL("image/png");
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({
      orientation: "landscape",
      unit: "px",
      format: [canvas.width, canvas.height],
    });
    pdf.addImage(imgData, "PNG", 0, 0, canvas.width, canvas.height);
    pdf.save("comparativa.pdf");
  });
});
});
