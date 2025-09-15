// Configuración global Chart.js (se aplica a todos los gráficos, pero puedes sobrescribir en cada gráfico).
Chart.defaults.color = "#5f6368"; // Color del texto.
Chart.defaults.backgroundColor = ["#1a73e8", "#D9D9D9"]; // Colores de fondo por defecto (no del gráfico, sino de las barras, lineas o elemento del gráfico).
Chart.defaults.borderColor = "#D9D9D9"; // Color del borde interno.
Chart.defaults.borderWidth = 2; // Ancho del borde interno.
Chart.defaults.font.family = "Roboto, sans-serif"; // Tipografía.
Chart.defaults.font.size = 10; // Tamaño de la fuente.
Chart.defaults.font.weight = "bold"; // Tipo de fuente.
Chart.defaults.responsive = true; // Marcarlo como responsive.
Chart.defaults.maintainAspectRatio = false; // No mantener la relación de aspecto (guay, ya que si lo dejas, es posible que hayan gráficos que empiecen a desplazarse hacia abajo sin sentido o que directamente no se adapten a medida que crece la ventana)
Chart.defaults.scale.grid.display = true; // Mostrar la cuadrícula de fondo.

// Leyenda global
Chart.defaults.plugins.legend.position = "bottom"; // Posición de la leyenda.
Chart.defaults.plugins.legend.labels.padding = 20; // Padding de la leyenda.
Chart.defaults.plugins.legend.labels.boxWidth = 18; // Anchura de la leyenda.
Chart.defaults.plugins.legend.labels.boxHeight = 18; // Altura de la leyenda.

// Tooltip global
Chart.defaults.plugins.tooltip.backgroundColor = "#5f6368"; // Color de fondo.
Chart.defaults.plugins.tooltip.titleColor = "#d9d9d9"; // Color del encabezado.
Chart.defaults.plugins.tooltip.bodyColor = "#d9d9d9"; // Color del texto.
Chart.defaults.plugins.tooltip.padding = 12; // Padding.
Chart.defaults.plugins.tooltip.cornerRadius = 8; // Bordes redondeados.
Chart.defaults.plugins.tooltip.caretSize = 8; // Tamaño de la flechita.

// Gráfico de la página principal.
function renderDownloadsByCity(downloads) {
  const cities = downloads.map(item => item.name);
  const totals = downloads.map(item => item.total);

  const ctx = document
    .getElementById("downloads-by-city-chart")
    .getContext("2d");

  new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: cities,
      datasets: [
        {
          label: "Total de descargas",
          backgroundColor: [
            "#ffb3c6", // Rosa claro
            "#ffd59e", // Amarillo claro
            "#fff685", // Amarillo
            "#a7e9c5", // Verde claro
            "#89caff", // Azul claro
            "#a393f7", // Lila claro
            "#e0aaff", // Lila
            "#ffb480", // Naranja claro
            "#b7efc5", // Verde
            "#76e5c9", // Verde agua
            "#b5b9ff", // Azul
            "#ffb7ce", // Rosa
          ],
          data: totals,
          hoverOffset: 10,
        },
      ],
    },
  });
}

// Gráfico de la página de descargas.
function renderDownloadsByDocumentRange(downloads) {
  if (!downloads || downloads.length === 0)
    $("#downloads-by-document-range-chart").hide();

  const labels = downloads.map(item => item.code);
  const data = downloads.map(item => item.total);

  const ctx = document
    .getElementById("downloads-by-document-range-chart")
    .getContext("2d");

  new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Total de descargas",
          data: data,
        },
      ],
    },
    options: {
      plugins: {
        legend: { display: false },
      },
      scales: {
        y: { beginAtZero: true },
      },
    },
  });
}

// Gráfico de la página de documentos y de la página de comparar documentos.
function renderDownloadsByDocument(
  documents,
  downloads,
  idCanvas = "documents-chart"
) {
  const documentsNames = documents.map(doc => doc.code);
  const downloadsByDocument = documents.map(doc => {
    const download = downloads.find(d => d.document_id === doc.id);
    return download ? download.total : 0;
  });

  const ctx = document.getElementById(idCanvas).getContext("2d");

  new Chart(ctx, {
    type: "bar",
    data: {
      labels: documentsNames,
      datasets: [
        {
          label: "Total de descargas",
          data: downloadsByDocument,
        },
      ],
    },
    options: {
      plugins: {
        legend: {
          display: false,
        },
      },
    },
  });
}

// Gráfico de la página de documento en concreto.
function renderDayWithMostDownloads(downloadsFromTopDay) {
  const downloadsByHour = {};

  for (let i = 0; i < downloadsFromTopDay.length; i++) {
    const hour = new Date(downloadsFromTopDay[i].date_time).getHours();

    if (!downloadsByHour[hour]) {
      downloadsByHour[hour] = 0;
    }
    downloadsByHour[hour]++;
  }

  const labels = [];
  const data = [];
  for (let hour in downloadsByHour) {
    let nextHour = parseInt(hour) + 1;
    if (nextHour === 24) {
      nextHour = 0;
    }
    labels.push(`${hour}:00 - ${nextHour}:00`);
    data.push(downloadsByHour[hour]);
  }

  const chartType = labels.length <= 2 ? "pie" : "bar";
  const displayBool = labels.length <= 2 ? true : false;

  const chartContainer = document.getElementById(
    "top-download-day-chart-container"
  );
  if (labels.length >= 5) {
    chartContainer.classList.add("chart-container--big");
  } else if (labels.length >= 3) {
    chartContainer.classList.add("chart-container--medium");
  } else {
    chartContainer.classList.add("chart-container--small");
  }

  const ctx = document
    .getElementById("top-download-day-chart")
    .getContext("2d");
  new Chart(ctx, {
    type: chartType,
    data: {
      labels: labels,
      datasets: [
        {
          label: "Total de descargas",
          data: data,
        },
      ],
    },
    options: {
      plugins: {
        legend: {
          display: displayBool,
        },
      },
      scales: {
        y: {
          display: false,
        },
      },
    },
  });
}

// Gráfico de la página de documento en concreto.
function renderDownloadsSincePublishmentDayUntilLastDownload(downloadsByDate) {
  let labels = downloadsByDate.map(item => item.download_date);
  labels = formatLabelsToSpanish(labels);
  const data = downloadsByDate.map(item => item.total_downloads);

  const ctx = document
    .getElementById("downloads-since-publishment-until-last-download-chart")
    .getContext("2d");

  new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Descargas por día",
          data: data,
          backgroundColor: "#D9D9D9",
          borderColor: "#1a73e8",
        },
      ],
    },
    options: {
      plugins: {
        legend: {
          display: false,
        },
      },
    },
  });
}

// Gráfico de la página de documento en concreto.
function renderDownloadsByMonth(downloads) {
  const labels = downloads.map(item => {
    const [year, month] = item.month.split("-");
    return month + "/" + year;
  });
  const data = downloads.map(item => item.total);

  const ctx = document.getElementById("downloads-by-month-chart").getContext("2d");
  new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels,
      datasets: [{
        label: "Descargas",
        data: data,
      }]
    },
    options: {
      plugins: {
        legend: { display: false }
      },
    }
  });
}

// Gráfico de la página de comparar.
function renderDownloadsEvolutionChart(data, selectedDocuments, documentNames) {
  const dates = [];
  data.forEach(d => {
    if (!dates.includes(d.date)) {
      dates.push(d.date);
    }
  });

  const datasets = selectedDocuments.map(docId => {
    return {
      label: documentNames[docId],
      data: dates.map(date => {
        const found = data.find(
          d => d.date === date && d.document_id == docId
        );
        return found ? found.total : null;
      }),
      borderColor: ["#ffb7ce", "#b7efc5", "#fff685", "#b5b9ff"],
      backgroundColor: "#D9D9D9",
    };
  });

  const labels = formatLabelsToSpanish(dates);

  const ctx = document
    .getElementById("downloads-evolution-chart")
    .getContext("2d");
  new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: datasets,
    },
    options: {
      spanGaps: true,
    },
  });
}


// Gráfico de la página de comparar.
function renderDownloadsPercentageChart(downloads) {
  const labels = downloads.map(item => item.code);
  const data = downloads.map(item => Number(item.total));
  const ctx = document
    .getElementById("downloads-percentage-chart")
    .getContext("2d");

  new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: labels,
      datasets: [
        {
          data: data,
          backgroundColor:
            labels.length == 2
              ? ["#1a73e8", "#D9D9D9"]
              : ["#ffb3c6", "#ffd59e", "#a7e9c5", "#fff685"],
          hoverOffset: 10,
        },
      ],
    },
    options: {
      plugins: {
        legend: {
          position: "bottom",
          labels: {
            generateLabels: function(chart) {
              const dataset = chart.data.datasets[0];
              const total = dataset.data.reduce((a, b) => a + b, 0);
              return chart.data.labels.map((label, i) => {
                const value = dataset.data[i];
                const percent = total ? ((value / total) * 100).toFixed(1) : 0;
                return {
                  text: `${label} (${percent}%)`,
                  fillStyle: dataset.backgroundColor[i],
                  strokeStyle: dataset.backgroundColor[i],
                  fontColor: '#5f6368',
                  index: i
                };
              });
            }
          }
        },
        tooltip: {
          callbacks: {
            label: function (context) {
              const total = context.dataset.data.reduce((a, b) => a + b, 0);
              const value = context.raw;
              const percent = total ? ((value / total) * 100).toFixed(2) : 0;
              return `${context.label}: ${percent}% (${value})`;
            },
          },
        },
      }
    },
  });
}

// Gráfico de la página de comparar.
function renderDownloadsByHourChart(downloads) {
  const labels = [];
  const data = [];
  for (let h = 0; h < 24; h++) {
    let nextHour = h + 1;
    if (nextHour === 24) nextHour = 0;
    labels.push(h + ":00 - " + nextHour + ":00");
    const found = downloads.find(item => parseInt(item.hour) === h);
    data.push(found ? parseInt(found.total) : 0);
  }
  
  const ctx = document.getElementById("downloads-by-hour-chart").getContext("2d");
  new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels,
      datasets: [{
        label: "Descargas",
        data: data,
      }]
    },
    options: {
      plugins: {
        legend: { display: false }
      },
    }
  });
}

// Función para formatear las etiquetas de fecha al español.
function formatLabelsToSpanish(labels) {
  return labels.map(label => {
    const date = new Date(label);
    return !isNaN(date)
      ? date.toLocaleDateString("es-ES", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
      })
      : label;
  });
}