<a href="https://quran.com">Qur'an</a> |
<a href="https://sunnah.com"><b>Sunnah</b></a> |
<a href="https://salah.com">Prayer Times</a> |
<a href="https://quranicaudio.com">Audio</a>
<div id="toggle-theme-btn">
  <img id="sun_theme_toogle_btn" src="./images/sun_icon.svg" alt="toggle Light Thme" />
  <img id="moon_theme_toggle_btn" src="./images/moon_icon.svg" alt="toggle Dark Thme" />
  
</div>
<script>
  const sun = document.getElementById("sun_theme_toogle_btn");
  const moon = document.getElementById("moon_theme_toggle_btn")
  const toggleThmeButtons = (isLight) => {

    if (isLight) {
      sun.style.display = "none";
      moon.style.display = "block";
    } else {
      sun.style.display = "block";
      moon.style.display = "none";
    }
  }
  const updateTheme = (isLight) => {
    toggleThmeButtons(isLight);
    const darkTheme = {
      '--global-text-color': 'white',
      '--primary-text-color': 'white',
      '--secondary-text-color': '#ffffff',
      '--toolbar-bg-color': '#272F33',
      '--header-bg': '#343A40',
      '--site-bg': '#1F2125',
      '--footer-bg': '#272F33',
      '--collection_sep_box_shadow': '0px 1px 2px 1px rgb(78 65 65 / 50%)',
      "--collection_sep_bg": "transparent",
      '--indexserachquery_bg': '#272F33',
      '--indexserachquery_shadow': '0px 0px 9pt 2pt #1a1919',
      '--collection_info_bg': '#272F33',
      '--collection-info_text_color': '#ffffff',
      '--book_title_odd_bg': 'transparent',
      '--book_title_even_bg': '#272F33',
      '--book_rannge_text_color': '#ffffff',
      '--crumbs_bg': '#272F33',
      '--searchquery_bg': '#272F33',
      '--searchquer_shadow': '0px 0px 9px 2pt #2b2b2d',
      '--secondry_block_bg': '#272F33',
      '--hadith_translation_color': '#ffffff',
      '--sidePanel_bg': '#272F33',
      '--indexsearchtips_bg': '#272F33',
      '--sanad_text_color': '#B3B6BC',
      "--highlight-color": "#3d938c",
      "--disable_button_bg": "#6C757D",
      "--boh_hover_bg": "#343A40"
    };

    const lightTheme = {
      '--global-text-color': 'none',
      '--primary-text-color': '#000',
      '--secondary-text-color': '#666',
      '--toolbar-bg-color': 'rgba(251, 250, 248, 0.2)',
      '--header-bg': 'url(../images/banner_small.png)',
      '--site-bg': 'url(../images/bg_small.png)',
      '--footer-bg': 'url(../images/banner_small.png)',
      '--collection_sep_box_shadow': '0px 1px 2px 1px rgba(204, 204, 204, 0.5)',
      "--collection_sep_bg": "#ccc",
      '--indexserachquery_bg': 'rgba(255, 255, 255, 0.65)',
      '--indexserachquery_shadow': '0px 0px 9pt 2pt #ccc',
      '--collection_info_bg': 'rgba(255, 255, 255, 0.5)',
      '--collection-info_text_color': '#666',
      '--book_title_odd_bg': 'rgba(255, 255, 255, 0.6)',
      '--book_title_even_bg': 'rgba(255, 255, 255, 0.4)',
      '--book_rannge_text_color': '#666',
      '--crumbs_bg': 'rgba(251, 250, 248, 0.2)',
      '--searchquery_bg': 'rgba(255, 255, 255, 0.85)',
      '--searchquer_shadow': '0px 0px 9pt 2pt #75a1a1',
      '--secondry_block_bg': 'rgba(255, 255, 255, 0.5)',
      '--hadith_translation_color': '#08081a',
      '--sidePanel_bg': 'url(../images/banner_small.png)',
      '--indexsearchtips_bg': 'rgba(255, 255, 255, 0.5)',
      '--sanad_text_color': 'gray',
      "--highlight-color": "#deebea",
      "--disable_button_bg": "#d6d6d6",
      "--boh_hover_bg": "#ffffff"
    };

    // Apply the selected theme
    Object.entries(isLight ? lightTheme : darkTheme).forEach(([variable, value]) => {
      document.documentElement.style.setProperty(variable, value);
    });



  }
  if (localStorage.getItem("theme")) {


    if (localStorage.getItem("theme") == "light") {
      updateTheme(true);
    } else {
      updateTheme(false)


    }

  } else {


    // user has not set theme for the website optting for deafult device theme
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) {
      updateTheme(true);
    } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      updateTheme(false);
    } else {
      // if for some reason device deafult theme is not set the deafult is light
      updateTheme(true);
    }

  }

  sun.addEventListener("click", () => {

    localStorage.setItem("theme", "light");
    updateTheme(true)
  })

  moon.addEventListener("click", () => {
    localStorage.setItem("theme", "dark");
    updateTheme(false)
  })
</script>