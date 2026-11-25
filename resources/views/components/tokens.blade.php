{{--
    Tokens de Meridiano incrustados en un <style>, para páginas que no cargan el CSS
    compilado de la app (páginas de error, páginas públicas independientes). Va en el
    <head>, antes de los estilos propios de la página.
--}}
<style data-meridiano-tokens>{!! \Slyn9\Meridiano\Tokens::css() !!}</style>
