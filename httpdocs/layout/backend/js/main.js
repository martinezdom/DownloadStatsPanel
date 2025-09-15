document.addEventListener("DOMContentLoaded", function () {
  logout();
  timeoutMessages();
  closeMessage();
  formatToSpanish();
  const menu = $(".header__menu");
  const menuTogglerBtn = $(".header__mobile-btn");
  menuToggler(menu, menuTogglerBtn);
  acordeon();
  goTopOrBottomButton();
});

function logout() {
  const logoutButton = document.querySelector(".header--item--logout");
  if (!logoutButton) {
    return;
  } else {
    logoutButton.addEventListener("click", function (event) {
      const confirmed = confirm("¿Seguro que desea cerrar sesión?");
      if (!confirmed) {
        event.preventDefault();
      }
    });
  }
}

function timeoutMessages(seconds = 3) {
  const messagesContainer = $(".message");
  if (messagesContainer.length > 0) {
    messagesContainer.each(function () {
      const item = $(this);
      setTimeout(() => {
        item.fadeOut(500, function () {
          item.remove();
        });
      }, seconds * 1000);
    });
  }
}

function closeMessage() {
  document.addEventListener("click", function (e) {
    if (e.target.classList.contains("btn-close")) {
      e.target.closest(".message").remove();
    }
  });
}

function formatToSpanish() {
  const dateElements = document.querySelectorAll(".date, .date-time");
  dateElements.forEach((el) => {
    const dateValue = el.innerText.trim();

    if (!dateValue) {
      return;
    }

    const newDate = new Date(dateValue);
    if (isNaN(newDate.getTime())) {
      return;
    }

    const options = el.classList.contains("date-time")
      ? {
          day: "2-digit",
          month: "2-digit",
          year: "numeric",
          hour: "2-digit",
          minute: "2-digit",
          second: "2-digit",
        }
      : { day: "2-digit", month: "2-digit", year: "numeric" };

    el.innerText = newDate.toLocaleString("es-ES", options).replaceAll(",", "");
  });
}

function menuToggler(menu, menuTogglerBtn) {
  menuTogglerBtn.click(function () {
    menu.toggleClass("active");

    if (menu.hasClass("active")) {
      if ($(".menu-closer").length === 0) {
        const closeListItem = $(
          '<li class="nav-item menu-closer"><a href="#"><i class="bi bi-x-lg header__menu-icon"></i></a></li>'
        );
        closeListItem.prependTo(menu);

        closeListItem.click(function (e) {
          e.preventDefault();
          closeMobileMenu(menu);
        });
      }

      $("body").css("overflow", "hidden");
      $('<div class="menu-overlay"></div>')
        .appendTo("body")
        .click(function () {
          closeMobileMenu(menu);
        });
    } else {
      closeMobileMenu(menu);
    }
  });
}

function closeMobileMenu(menu) {
  menu.removeClass("active");
  $("body").css("overflow", "");
  $(".menu-overlay").remove();
  $(".menu-closer").remove();
}

function acordeon() {
  const rows = document.querySelectorAll(
    ".table__row--body--documents td:first-child, .table__row--body--downloads td:first-child"
  );

  rows.forEach((row) => {
    row.addEventListener("click", function () {
      this.parentElement.classList.toggle("active");
    });
  });
}

function goTopOrBottomButton() {
  const btn = document.querySelector(".go-top-bottom-button");
  if (!btn) return;

  btn.innerHTML = '<i class="bi bi-arrow-down"></i>';

  window.addEventListener("scroll", function () {
    if (window.scrollY > 200) {
      btn.classList.add("visible");
      btn.innerHTML = '<i class="bi bi-arrow-up"></i>';
      btn.dataset.direction = "up";
    } else {
      btn.classList.add("visible");
      btn.innerHTML = '<i class="bi bi-arrow-down"></i>';
      btn.dataset.direction = "down";
    }
  });

  btn.addEventListener("click", function (e) {
    e.preventDefault();
    if (btn.dataset.direction === "up") {
      window.scrollTo({ top: 0, behavior: "smooth" });
    } else {
      window.scrollTo({ top: document.body.scrollHeight, behavior: "smooth" });
    }
  });
}