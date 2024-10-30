$(document).ready(function () {
  console.log("user.js abierto");

  $(".owl-carousel").owlCarousel({
    loop: true,
    autoplay: true,
    autoplayTimeout: 10000,
    autoplaySpeed: 1000,
    responsive: {
      0: {
        items: 1,
      },
      750: {
        items: 2,
        margin: 20,
      },
      1000: {
        items: 3,
        margin: 20,
      },
      1400: {
        items: 4,
        margin: 20,
      },
    },
  });

  function openEditModal(event) {
    const idTest = event.target.getAttribute("data-id");
    const editLink = document.getElementById("editModalLink");
    editLink.href = `test_form.php?idTest=${idTest}`;
  }

  function openDeleteModal(event) {
    const idTest = event.target.getAttribute("data-id");
    const deleteLink = document.getElementById("deleteModalLink");
    deleteLink.href = `ajax/deleteTest.php?idTest=${idTest}`;
  }

  document.querySelectorAll(".edit-btn").forEach((button) => {
    button.onclick = openEditModal;
  });

  document.querySelectorAll(".delete-btn").forEach((button) => {
    button.onclick = openDeleteModal;
  });
});
