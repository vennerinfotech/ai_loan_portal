 const checkboxes = document.querySelectorAll('.upload_header input');

  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('change', function () {
      const card = this.closest('.upload_card');

      if (this.checked) {
        card.classList.add('active');
      } else {
        card.classList.remove('active');
      }
    });
  });
