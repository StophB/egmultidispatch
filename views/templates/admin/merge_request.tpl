{*
 * 2023 (c)  Egio digital
 *
 * MODULE EgMultidispatch
 *
 * @author    Egio digital
 * @copyright Copyright (c) , Egio digital
 * @license   Commercial
 * @version    1.0.0
*}

<div class="eg-page-head with-tabs">
    <div class="eg-page-head-tabs" id="head_tabs">
        <ul class="nav">
            <li>
                <a href="{$link->getAdminLink('AdminEgSqlExecute')}" id="AdminEgManageMultidispatch">
                    <i class="icon-cogs"></i>
                    {l s='SQL Execute' mod='egmultidispatch'}
                    <span class="notification-container">
                    <span class="notification-counter"></span>
                    </span>
                </a>
            </li>
            <li>
                <a href="{$link->getAdminLink('AdminEgMergeRequeste')}" id="AdminEgMergeRequeste" class="current">
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
        <h2>{l s='Merge requeste' mod='egmultidispatch'}</h2>
    </div>
    <form action="" method="post">
        <div class="panel-body">
            <div class='col-md-6'>
                <div class="col-md-2">
                    <div class="form-group">
                        <select class="form-control" id="actionDropdown">
                            <option disabled selected>Branch from</option>
                            <option>Branch from 1</option>
                            <option>Branch from 2</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <p class="h3">{l s='Branches sites adherant' mod='connecteuradherant'}</p>
                <ul>
                    {foreach $branchs as $branch }
                        <li>
                            <label class="form-check-label" for="defaultCheck1">
                                <input class="form-check-input seller_id"
                                       type="checkbox"
                                       value="{$branch.id_eg_multidispatch}"
                                       name='id[]'
                                       {if in_array($branch.id_eg_multidispatch, $selectedBranch)}checked{/if}>
                                {$branch.branch}
                            </label>
                        </li>
                    {/foreach}
                </ul>
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
                <button type="button" name='submit' id="submit" class="btn btn-primary pull-right">{l s='Submit' mod='egmultidispatch'}</button>
            </div>
        </div>
    </form>
</div>
