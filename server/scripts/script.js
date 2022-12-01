"use strict";

// VER CONTACTO DE ARTÍCULO

const $cards = document.querySelectorAll(`.articles .card`);

$cards.forEach((card) => {
  card.addEventListener(`click`, (e) => {
    e.target.classList.toggle(`rotate`);
  });
});

// COLOR DEL ICONO DE FAVORITOS:

const $iconFavorites = document.querySelectorAll(`.articles .card .favorite`);

$iconFavorites.forEach((icon) => {
  icon.addEventListener(`click`, async (e) => {
    // modificamos estilo
    icon.classList.toggle(`like`);
    // modificamos en la base de datos
    const idArticle = e.target.getAttribute(`data-idarticle`);
    const isLike = e.target.classList.contains(`like`);

    try {
      const data = new FormData();
      data.append("action", "change-favorites");
      data.append("id", idArticle);
      data.append("like", isLike);
      // const resp = await fetch(`https://onlinepluslocal.cmrr.es/index.php`, {
      const resp = await fetch(`./index.php`, {
        method: "POST",
        body: data,
      });
    } catch (error) {
      console.log("%c%s", "color: #ff0000", error.message);
    }
  });
});
