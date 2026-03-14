module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./storage/framework/views/*.php",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
  ],
  safelist: [
    'fa-solid',
    'fa-eye',
    'fa-trash',
    'fa-fw',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
