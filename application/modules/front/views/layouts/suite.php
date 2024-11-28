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
    if (theme == 'light') {
      sun.style.display = "none";
      moon.style.display = "block";
    } else if (theme == 'dark'){
      sun.style.display = "block";
      moon.style.display = "none";
    }
  };

  const updateTheme = (theme) => {
    toggleThemeButtons(theme);
    document.body.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
  };

  const initializeTheme = () => {
    const savedTheme = localStorage.getItem("theme");
    const preferredColorScheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';

    if(savedTheme)
      updateTheme(savedTheme);
    else if(preferredColorScheme)
      updateTheme(preferredColorScheme);
    else
      updateTheme('light');
  };

  sun.addEventListener("click", () => updateTheme("light"));
  moon.addEventListener("click", () => updateTheme("dark"));

  initializeTheme();
</script>