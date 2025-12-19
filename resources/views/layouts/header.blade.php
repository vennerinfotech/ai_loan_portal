  <style>
      header {
          position: absolute;
          width: 100%;
          top: 0;
          z-index: 99;
      }

      .container {
          max-width: 1200px;
          margin: 0 auto;
          padding: 0 20px;
      }

      .header-content {
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding-top: 50px
      }

      .logo {
          font-size: 24px;
          font-weight: bold;
          color: #fff;
      }

      nav {
          display: flex;
          align-items: center;
          gap: 32px;
      }

      nav a {
          color: #fff;
          text-decoration: none;
          font-size: 16px;
          font-weight: 400;
          transition: color 0.3s;
          position: relative;
      }

      nav a:before {
          content: '';
          position: absolute;
          width: 100%;
          height: 1px;
          bottom: -4px;
          left: 0;
          background-color: #fff;
          transform: scaleX(0);
          transition: transform 0.3s ease;
      }

      nav a:hover:before {
          transform: scaleX(1);
      }

      .apply-btn {
          background-color: #fff;
          color: #252484;
          border: none;
          padding: 10px 40px;
          border-radius: 8px;
          font-weight: 500;
          cursor: pointer;
          transition: all 0.5s ease-in-out;
      }

      .apply-btn:hover {
          background-color: #6765e8;
          color: #ffffff;
          transition: all 0.5s ease-in-out;
      }

      .menu-toggle {
          display: none;
          background: none;
          border: none;
          cursor: pointer;
          padding: 8px;
          border-radius: 6px;
          transition: background-color 0.3s;
      }

      .menu-toggle .menu-icon i {
          color: #fff;
          font-size: 20px;
      }

      .mobile-menu {
          display: none;
          flex-direction: column;
          gap: 8px;
          border-radius: 20px;
          background-color: #fff3;
          backdrop-filter: blur(10px);
          padding: 20px 10px 30px;
      }

      .mobile-menu.active {
          display: flex;
      }

      .mobile-menu a {
          color: #fff;
          text-decoration: none;
          font-size: 16px;
          font-weight: 500;
          padding: 7px 10px;
          border-radius: 6px;
          transition: all 0.3s;
      }

      .mobile-menu a:hover {
          color: #2b2a8d;
          background-color: #c7d2fe;
      }

      .mobile-menu .apply-btn {
          width: 100%;
          margin-top: 8px;
      }

      @media (max-width: 990px) {
          nav {
              display: none;
          }

          .menu-toggle {
              display: block;
          }

          .header-content {
              padding-top: 20px;
          }
      }
  </style>

  <header>
      <div class="container">
          <div class="header-content">
              <div class="logo">LOGO</div>

              <nav>
                  <a href="#home">Home</a>
                  <a href="#customers">Customers</a>
                  <a href="#collaborator">Collaborator</a>
                  <a href="#team">Meet the team</a>
                  <a href="#contact">Contact Us</a>
                  <button class="apply-btn">Apply Now</button>
              </nav>

              <button class="menu-toggle" id="menuToggle">
                  <span class="menu-icon">
                      <i class="fa-solid fa-bars"></i>
                  </span>
              </button>
          </div>

          <div class="mobile-menu" id="mobileMenu">
              <a href="#home">Home</a>
              <a href="#customers">Customers</a>
              <a href="#collaborator">Collaborator</a>
              <a href="#team">Meet the team</a>
              <a href="#contact">Contact Us</a>
              <button class="apply-btn">Login</button>
          </div>
      </div>
  </header>

  <script>
      const menuToggle = document.getElementById('menuToggle');
      const mobileMenu = document.getElementById('mobileMenu');

      menuToggle.addEventListener('click', function() {
          this.classList.toggle('active');
          mobileMenu.classList.toggle('active');
      });

      // Close menu when clicking on a link
      const mobileLinks = mobileMenu.querySelectorAll('a');
      mobileLinks.forEach(link => {
          link.addEventListener('click', function() {
              menuToggle.classList.remove('active');
              mobileMenu.classList.remove('active');
          });
      });
  </script>
