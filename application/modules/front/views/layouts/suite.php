<a href="https://quran.com">Qur'an</a> |
<a href="https://sunnah.com"><b>Sunnah</b></a> |
<a href="https://salah.com">Prayer Times</a> |
<a href="https://quranicaudio.com">Audio</a>
<div id="toggle-theme-btn">
  <img id="sun_theme_toogle_btn" src="/images/sun_icon.svg" alt="toggle Light Thme" />
  <img id="moon_theme_toggle_btn" src="/images/moon_icon.svg" alt="toggle Dark Thme" />
</div>
<script>
  const sun = document.getElementById("sun_theme_toogle_btn");
  const moon = document.getElementById("moon_theme_toggle_btn");

  const toggleThemeButtons = (theme) => {
    if (theme === "light") {
      sun.style.display = "none";
      moon.style.display = "block";
    } else {
      sun.style.display = "block";
      moon.style.display = "none";
    }
  };
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
    "--boh_hover_bg": "#343A40",
    "--button_expand_gradient":"linear-gradient(#343a4040, #343a40a8 20%, #343a40 100%)"
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
    "--boh_hover_bg": "#ffffff",
    "--button_expand_gradient":"linear-gradient(rgba(255, 255, 255, 0), rgba(255, 255, 255, 51%) 20%, #faf9f6 100%)"
  };

  const updateTheme = (theme) => {
    toggleThemeButtons(theme);
    const themeVariables = theme === "light" ? lightTheme : darkTheme;
    Object.entries(themeVariables).forEach(([variable, value]) => {
      document.documentElement.style.setProperty(variable, value);
    });
  };

  const initializeTheme = () => {
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme) {
      updateTheme(savedTheme);
    } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) {
      updateTheme("light");
    } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      updateTheme("dark");
    } else {
      updateTheme("light");
    }
  };
  sun.addEventListener("click", () => {
    localStorage.setItem("theme", "light");
    updateTheme("light")
  })

  moon.addEventListener("click", () => {
    localStorage.setItem("theme", "dark");
    updateTheme("dark")
  })
  initializeTheme();
</script>