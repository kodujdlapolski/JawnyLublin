

jQuery(document).ready(function ($) {


	$('.period-menu li').on('click', function(e){

		var link = $(this);
		var year_param = link.attr('year_param');

		$('.period-menu li').removeClass('default');
		link.toggleClass('default');

		$('.sallary_scroll').attr('year_param', year_param);
		update_ammounts(tax_info);
		e.preventDefault();
	});

	update_ammounts(tax_info);

	$(".sallary_scroll").noUiSlider({

		range:[0, 8000], slide:triggerChange, start:$("#sallary_scroll_field").val(), handles:1, step: 10, serialization:{
			to:$("#sallary_scroll_field"),  resolution: 1
		}

	});


  jQuery('input#sallary_scroll_field').change(function() {
		update_ammounts(tax_info);
	});


	/**
	 * Funckcja w petli aktualizuje wartosci udziału w wydatkach na poszczegolne kategorii w zaleznosci z pensji
	 *
	 * @param tax_info
	 */
	function update_ammounts(tax_info){
    var year_param = $('.sallary_scroll').attr('year_param');
		var $tax_ammount_container = $('.tax-ammount span');

		$(".expenses-list li").each(function( index ) {
			var $row = $( this );
			var amount_budget = parseFloat($row.attr('data-amount-budget'));
			var cost_share = amount_budget/parseFloat(tax_info.wykonane_wydatki);

			var user_tax = get_user_tax();

			var tax_city_sum =  parseFloat(tax_info.dochdowy_dla_gminy) + parseFloat(tax_info.dochdowy_dla_powiatu);

			var user_city_tax = user_tax*tax_city_sum;

			var tax_share = parseFloat(cost_share* user_city_tax, 7);

           if(year_param=='1'){
            var user_tax_round = Math.round(user_tax*100)/100;
           }else{
             var user_tax_round = Math.round(user_tax*100/12)/100;
           }

            $tax_ammount_container.number( user_tax_round, 2, ',', ' ' );

			if(year_param=='1'){
				var string_ammount = Math.round(tax_share*100)/100;
			}else{
				var string_ammount = Math.round(tax_share*100/12)/100;
			}


			$row.find('.data-amount-info span').number( string_ammount, 2, ',', ' ' );
		});
	}

	/**
	 * Funckja wykonywana w trakcie stosowania suwaka
	 */
	function triggerChange() {

		update_ammounts(tax_info);

	}

	/**
	 * Funkcja obliczajaca podatek uzytkownika za miesiac
	 * @return {Number}
	 */
	function get_user_tax_old(){
		var user_salary =  parseFloat($("#sallary_scroll_field").val());
		var ubezpieczenie_spoleczne = parseFloat(tax_info.ubezpieczenie_spoleczne) *user_salary;
	  var koszty_uzyskania =  parseFloat(tax_info.koszty_uzyskania);
		var podstawa_wymiaru_skladki = user_salary - ubezpieczenie_spoleczne - koszty_uzyskania;
		var ubezpieczenie_zdrowotne = (podstawa_wymiaru_skladki + koszty_uzyskania)*0.09;
		var ubezpieczenie_zdrowotne_do_odliczenia  = Math.round((podstawa_wymiaru_skladki + koszty_uzyskania)*parseFloat(tax_info.ubezpieczenie_zdrowotne_stawka_2));



		var kwota_wolna = parseFloat(tax_info.kwota_wolna);
		var kwota_drugi_prog =  parseFloat(tax_info.kwota_drugi_prog);

		if(user_salary*12>kwota_wolna && user_salary*12 <=kwota_drugi_prog){

			var user_tax = podstawa_wymiaru_skladki * parseFloat(tax_info.stawka_pierwsza)-ubezpieczenie_zdrowotne_do_odliczenia-parseFloat(tax_info.kwota_zmniejszajaca);
		}else if(user_salary*12 > kwota_drugi_prog){

			var user_tax = podstawa_wymiaru_skladki * parseFloat(tax_info.stawka_druga)-ubezpieczenie_zdrowotne_do_odliczenia-parseFloat(tax_info.kwota_zmniejszajaca);
		}


	if(user_salary*12<=kwota_wolna ){
		return 0
	}else{
		return user_tax;
	}

	}

	function get_user_tax(){
		var user_salary =  parseFloat($("#sallary_scroll_field").val());
		var ubezpieczenie_spoleczne = parseFloat(tax_info.ubezpieczenie_spoleczne) *user_salary;
		var koszty_uzyskania =  parseFloat(tax_info.koszty_uzyskania);
		var podstawa_wymiaru_skladki = user_salary - ubezpieczenie_spoleczne - koszty_uzyskania;
		var ubezpieczenie_zdrowotne = (podstawa_wymiaru_skladki + koszty_uzyskania)*0.09;
		var ubezpieczenie_zdrowotne_do_odliczenia  = Math.round((podstawa_wymiaru_skladki + koszty_uzyskania)*parseFloat(tax_info.ubezpieczenie_zdrowotne_stawka_2));



		var kwota_wolna = parseFloat(tax_info.kwota_wolna);
		var kwota_drugi_prog =  parseFloat(tax_info.kwota_drugi_prog);

		if(user_salary*12>kwota_wolna && user_salary*12 <=kwota_drugi_prog){

			var user_tax = podstawa_wymiaru_skladki * parseFloat(tax_info.stawka_pierwsza)-ubezpieczenie_zdrowotne_do_odliczenia-parseFloat(tax_info.kwota_zmniejszajaca);
		}else if(user_salary*12 > kwota_drugi_prog){

			var user_tax = podstawa_wymiaru_skladki * parseFloat(tax_info.stawka_druga)-ubezpieczenie_zdrowotne_do_odliczenia-parseFloat(tax_info.kwota_zmniejszajaca);
		}


		if(user_salary*12<=kwota_wolna|| user_tax<=0){
			return 0
		}else{
			return user_tax;
		}

	}
	function get_user_tax_old2(){
		var user_salary =  parseFloat($("#sallary_scroll_field").val());
		var podstawa_wymiaru_skladki = user_salary *12;


		var kwota_zmniejszajaca = parseFloat(tax_info.kwota_zmniejszajaca)*12;

		var kwota_wolna = parseFloat(tax_info.kwota_wolna);
		var kwota_drugi_prog =  parseFloat(tax_info.kwota_drugi_prog);
		if(user_salary*12>kwota_wolna && user_salary*12 <=kwota_drugi_prog){

			var user_tax = podstawa_wymiaru_skladki * parseFloat(tax_info.stawka_pierwsza)-kwota_zmniejszajaca;

		}else if(user_salary*12 > kwota_drugi_prog){

			var user_tax = podstawa_wymiaru_skladki * parseFloat(tax_info.stawka_druga)-kwota_zmniejszajaca;
		}


		if(user_salary*12<=kwota_wolna){
			return 0
		}else{
			return user_tax;
		}

	}
});




