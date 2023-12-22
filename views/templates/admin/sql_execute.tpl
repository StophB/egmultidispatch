{**
 * 2020  (c)  Egio digital
 *
 * MODULE EgMultidispatch
 *
 * @author    Egio digital
 * @copyright Copyright (c) , Egio digital
 * @license   Commercial
 * @version    1.0.0
 */
 *}

<div class="eg-page-head with-tabs">
    <div class="eg-page-head-tabs" id="head_tabs">
        <ul class="nav">
            <li>
                <a href="{$link->getAdminLink('AdminEgSqlExecute')}" id="AdminEgManageMultidispatch" class="current">
                    <i class="icon-cogs"></i>
                    {l s='SQL Execute' mod='egmultidispatch'}
                    <span class="notification-container">
                    <span class="notification-counter"></span>
                    </span>
                </a>
            </li>
            <li>
                <a href="{$link->getAdminLink('AdminEgMergeRequeste')}" id="AdminEgMergeRequeste">
                    <i class="icon-cogs"></i>
                    {l s='Merge requeste' mod='egmultidispatch'}
                    <span class="notification-container">
                    <span class="notification-counter"></span>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h2>{l s='Requette SQL' mod='egmultidispatch'}</h2>
    </div>
    <form action="" method="post">
        <div class="panel-body">
            <div class='col-md-4'>
                <div class="form-group row textarea-widget">
                    <label class="form-control-label" for="sql_request">
                        SQL query
                    </label>
                    <div class="col-sm input-container">
                        <textarea id="sql_request" name="sql_request" rows="10" class="form-control form-control"></textarea>
                    </div>
                </div>
            </div>

            <div class='col-md-6' style='margin-left: 250px;'>
                <p class="h3">{l s='BDD sites adherant' mod='egmultidispatch'}</p>
                {if $databases}
                    <ul>
                        {foreach from=$databases item=database}
                            <li class="col-md-6">
                                <label class="form-check-label" for="defaultCheck1">
                                    <input class="form-check-input" type="checkbox"
                                           {if in_array($database, array_column($checkedDatabases, 'database'))}checked{/if}
                                           value="{$database}" name='databases[]'>
                                    {$database}
                                </label>
                            </li>
                        {/foreach}
                    </ul>
                {/if}
            </div>

        </div>
        <div class="panel-footer">
            <div class='text-center'>
                <nav>
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#"><</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">></a></li>
                    </ul>
                </nav>
            </div>
            <div class=''>
                <div class="cardscontainer">
                    <button type="submit" name='submitQuery' class="btn btn-primary pull-right">{l s='Submit Query' mod='egmultidispatch'}</button>
                </div>
            </div>
        </div>
    </form>
</div>




