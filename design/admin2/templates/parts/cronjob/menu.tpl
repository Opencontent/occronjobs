{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h4>{'Cronjobs'|i18n('extension/occronjobs')}</h4>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

<ul>
    <li><div><a href={'/cronjobs/show_crontab/'|ezurl}>Crontab</a></div></li>
    <li><div><a href={'/cronjobs/crontab/'|ezurl}>{'Crontab list'|i18n('extension/occronjobs')}</a></div></li>
    {*<li><div><a href={'/cronjobs/list/'|ezurl}>{'Active eZ cronjobs'|i18n('extension/occronjobs')}</a></div></li>*}
    <li><div><a href={'/cronjobs/logs/'|ezurl}>{'Last logs'|i18n('extension/occronjobs')}</a></div></li>
    <li><div><a href={'/cronjobs/clear/'|ezurl}>{'Clear logs'|i18n('extension/occronjobs')}</a></div></li>
</ul>
{* DESIGN: Content END *}</div></div></div></div></div></div>