{assign var="saludo" value="Hola"}
<h1>{$saludo} {$nombre}</h1>

{if $edad >= 18}
    <p class="text-success">Mayor de edad</p>
{else}
    <p class="text-warning">Menor de edad</p>
{/if}

<h3>Usuarios:</h3>
<ul>
{foreach from=$usuarios item=u}
    <li><strong>{$u.nombre}</strong> - {$u.edad} años</li>
{/foreach}
</ul>