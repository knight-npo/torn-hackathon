$(document).ready(function() {
    formatStocks()
    formatPointsMarket()

    const item = new URL($(location).attr("href")).pathname.split('/').pop()
    $('.nav-link').each(function() {
        if($(this).hasClass('disabled')) {
            $(this).removeClass('active')
        }
    })
    $('#ni-'+item).addClass('active')

    $('.nav-underline').on('click', 'a', function(e) {
        showCountry($(e.target).attr('data-country'))
    })

    $('.stock-table').on('post-body.bs.table', function (e) {
        formatStocks(e.target)
    })
    $('#point-market-table').on('post-body.bs.table', function (e) {
        formatPointsMarket()
    })

    showCountry('mex')
    $('#nav-countries').show()
    $('#point-market-table').show()
});

function activateCountry(id) {
    $('.nav-underline > li > a').each(function() {
        $(this).removeClass('active')
    })
    $('[data-country="'+id+'"]').addClass('active')
}

function showCountry(country) {
    activateCountry(country)
    $('.stock-table').each(function() {
        const id = $(this).attr('id')
        if (!id.includes(country)) {
            $(this).hide()
        } else {
            $(this).show()
        }
    })
}

function formatStocks(obj) {
    const format = function(elem) {
        const costElem = $(elem).find('td:nth-child(3)')
        const cost = parseInt(costElem.html())
        costElem.html('$'+cost.toLocaleString())
        
        const timestamp = $(elem).find('td:nth-child(5)')
        const now = Math.round(Date.now() / 1000)
        const diff = Math.round((parseInt($(timestamp).html()) - now)/60)
        const rtf = new Intl.RelativeTimeFormat('en', { style: 'long' });
        $(timestamp).html(rtf.format(diff, 'minutes'))
    }

    if (obj !== undefined) {
        $(obj).find('tbody > tr:nth-child(n)').each(function() {
            format($(this))
        });
        return
    }

    $('.stock-table > tbody > tr:nth-child(n)').each(function() {
        format($(this))
    });
}

function formatPointsMarket() {
    const format = function(elem, pref) {
        const num = parseInt(elem.html())
        elem.html(pref+num.toLocaleString())
    }
    $('#point-market-table > tbody > tr:nth-child(n)').each(function() {
        format($(this).find('td:nth-child(2)'), '')
        format($(this).find('td:nth-child(3)'), '$')
        format($(this).find('td:nth-child(4)'), '$')
    });
}
