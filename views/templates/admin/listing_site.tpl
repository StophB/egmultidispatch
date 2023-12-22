{*
* 2007-2023 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2023 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="panel panel-default">
    <div class="panel-heading">
        <div>
            <h2>{l s='Choose a site adheran' mod='egmultidispatch'}</h2>
        </div>
        <div class='text-right'>
            <a class="btn-primary btn" id="" href="{$LinkControlleradd}">{l s='Add site' mod='egmultidispatch'}</a>
        </div>
    </div>
    <div>
        <form action="" name='' method='post' id="">
            <div class="panel-body">
                <div class='row'>
                    <ul>
                        {foreach $sites as $site }
                            <li>
                                <label class="form-check-label" for="defaultCheck1">
                                    <input class="form-check-input seller_id"  type="checkbox" value="{$site.id_eg_multidispatch}" name='id[]'>
                                    {$site.adherant}
                                </label>
                            </li>
                        {/foreach}
                    </ul>
                </div>
            </div>
            <div class="panel-footer">
                <div class='col-md-6'>
                    <div class="col-md-2">
                        <div class="form-group">
                            <select class="form-control" id="actionDropdown">
                                <option selected disabled>Actions groupées </option>
                                <option>Action 1</option>
                                <option>Action 2</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class='text-left'>
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
                    <div class='text-right'>
                        <input type="submit" class="btn-primary btn" name="submitSites" value="{l s='submit' mod='egmultidispatch'}">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
