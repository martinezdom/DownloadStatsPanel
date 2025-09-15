$(document).ready(function () {
  const input = $("#search-input");
  const table = $("#documents-table, #downloads-table");
  const select = $("#cell");

  input.on("input", function () {
    searchTable();
  });

  function searchTable() {
    const filterValue = input.val().toUpperCase();
    const selectedColumn = select.val();
    const rows = table.find("tbody tr");

    let hasResults = false;

    rows.each(function () {
      const row = $(this);
      if (row.attr("id") === "no-results-message") {
        return true;
      }

      const cells = row.find("td");
      let found = false;

      if (selectedColumn === "id") {
        found = cells.eq(1).text().toUpperCase().includes(filterValue);
      } else if (selectedColumn === "code") {
        found = cells.eq(2).text().toUpperCase().includes(filterValue);
      } else if (selectedColumn === "date") {
        found = cells.eq(3).text().toUpperCase().includes(filterValue);
      } else if (selectedColumn === "place") {
        found = cells.eq(4).text().toUpperCase().includes(filterValue);
      } else if (selectedColumn === "city") {
        found = cells.eq(5).text().toUpperCase().includes(filterValue);
      }

      row.toggle(found);
      if (found) {
        hasResults = true;
      }
    });

    if (!hasResults && filterValue !== "") {
      showNoResultsMessage();
    } else {
      removeNoResultsMessage();
    }
  }

  function showNoResultsMessage() {
    if ($("#no-results-message").length === 0) {
      const messageRow = $("<tr>");
      messageRow.attr("id", "no-results-message");
      const messageCell = $("<td>");
      messageCell.text("No se han encontrado resultados");
      messageCell.attr("colspan", table.find("th").length);
      messageRow.append(messageCell);
      table.find("tbody").append(messageRow);
    }
  }

  function removeNoResultsMessage() {
    $("#no-results-message").remove();
  }
});