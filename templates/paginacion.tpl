        <ul id="paginacion">
            {foreach from=$paginacion item=valor}
            <li>
                <a href="?p={$valor.p}" alt="{$valor.p}">{$valor.texto}</a>
            </li>
            {/foreach}
        </ul>
        