<section id="menu">
  <div class="padd">
    <header>
      <nav>
        <ul>
          <li>
             <div class="margen left">
               <img class="logo_unam" src="<?php echo constant('URL'); ?>public/img/escudounam_gris.png">
             </div>
           </li>
          <li>
             <div class="margen right">
               <ul id="menu_buttons">
                 <li>
                   <button onClick="window.location = '<?php echo constant('URL'); ?>home'">
                     <span class="glyphicon glyphicon-home"></span>Inicio
                   </button>
                 </li>
                 <li>
                   <button onClick="window.location = '<?php echo constant('URL'); ?>update'" style="width:130px;">
                    <span class="glyphicon glyphicon-upload"></span>Actualizar BD
                   </button>
                 </li>
                 <li>
                   <button onClick="window.location = '<?php echo constant('URL'); ?>salir/saliendo'">
                     <span class="glyphicon glyphicon-log-out"></span>Salir
                   </button>
                 </li>
               </ul>
             </div>
          </li>
        </ul>
      </nav>
    </header>
  </div>
</section>
