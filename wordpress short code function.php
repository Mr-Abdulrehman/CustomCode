<?php

function gt3_child_scripts() {
	wp_enqueue_style( 'gt3-parent-style', get_template_directory_uri(). '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'gt3_child_scripts' );

/**
 * Your code here.
 *
 */
//function stats_box($atts, $content = null)
//{

//	$stats = json_decode(file_get_contents("https://p2papi.kuflink.co.uk/api/deals/stats"));

//	setlocale(LC_MONETARY, 'en_GB');

//	$total_investment = '£' . number_format( (float) $stats->total_investment, 0, '.', ',' );
//	$num_investments = number_format($stats->number_of_investments);

//setlocale(LC_MONETARY, 'en_GB');
//$total_investment = utf8_encode(money_format('%n', $stats->total_investment));

//	$html = "<div class=\"container\"><div class=\"box--stats\"><div class=\"box__top\">";
//	$html .= "<div class=\"stat\"><div class=\"stat__value\">{$total_investment}</div><div class=\"stat__name\">Total Amount Invested</div></div>";
//	$html .= "<div class=\"stat\"><div class=\"stat__value\">{$num_investments}</div><div class=\"stat__name\">Number of Investments</div></div>";
//	$html .= "<div class=\"stat\"><div class=\"stat__value\">0</div><div class=\"stat__name\">Losses to Date</div></div>";
//	$html .= "</div></div></div>";

//	return $html;

//}


function stats_amount($atts, $content = null)
{
	$stats = json_decode(file_get_contents("https://p2papi.kuflink.co.uk/api/deals/stats"));
	
	setlocale(LC_MONETARY, 'en_GB');
	
	$total_investment = '£' . number_format( (float) $stats->total_investment, 0, '.', ',' );
	
	$html = "<p>{$total_investment}</p>";
		
	return $html;
}

function stats_investment($atts, $content = null)
{
	$stats = json_decode(file_get_contents("https://p2papi.kuflink.co.uk/api/deals/stats"));
	
	setlocale(LC_MONETARY, 'en_GB');
	
	$num_investments = number_format($stats->number_of_investments);
	
	$html = "<p>{$num_investments}</p>";
		
	return $html;
}




// /deals
function deals_shortcode($atts, $content = null) 
{

$api = json_decode(file_get_contents('https://p2papi.kuflink.co.uk/api/website-deals'));
$deals = $api->deals;

$html = "<div class=\"grid\">";

for( $i= 0 ; $i < count($deals); $i++ ) {
    $deal = $deals[$i];
    $deal->loan_term = number_format($deal->loan_term);
    $deal->loan_amount = number_format($deal->loan_amount, 2);
    $deal->kuflink_guarantee = number_format($deal->kuflink_guarantee, 2);
    $deal->investors_part = number_format($deal->investors_part, 2);
    $deal->deal_close_date = (new DateTime($deal->deal_close_date))->format('j/n/Y');
    $deal->loan_end_date = (new DateTime($deal->loan_end_date))->format('j/n/Y');

    $percent = "{$api->total_invested_percentage[$i]}%";
	$percent_value = "{$api->total_invested_percentage[$i]}";
    $interest_rate = number_format($deal->rate_of_return * 12, 2);
	
	$html .="<div class=\"grid_inner\">";
	$html .="<div class=\"grid_inner_one_third_box\">";
    $html .= "<div class=\"kufflink_card_box\"><div class=\"card_img_box\">";
    $html .= "<img src=\"{$deal->file_name}\" alt=\"Investment Area\">";
	$html .= "</div>";
    $html .= "<div class=\"card_description_area\">";
    $html .= "<h3> <span class=\"hdng_top_text\">Availabe to invest</span><span class=\"text\">{$deal->loan_name}</span></h3>";
//	  $html .="<p>Opportunity close: {$deal->deal_close_date}</p>";
//    $html .= "<table><tbody>";
//    $html .= "<tr><td>Loan Term</td><td class=\"align-right\">{$deal->loan_term} months</td></tr>";

//    $html .= "<tr><td>Borrowers loan end date</td><td class=\"align-right\">{$deal->loan_end_date}</td></tr>";
//    $html .= "<tr><td>Total Loan Amount</td><td class=\"align-right\">&pound;{$deal->loan_amount}</td></tr>";
//    $html .= "<tr><td class=\"white-text\">Kuflink Bridging Stake</td><td class=\"align-right white-text\">&pound;{$deal->kuflink_guarantee}</td></tr>";
//    $html .= "<tr><td>Other Lenders</td><td class=\"align-right\">&pound;{$deal->investors_part}</td></tr>";
//    $html .= "</tbody></table></div></div>";

    $html .= "<div class=\"progress_box\">";
	
	$html .= "<label for=\"progress\">{$percent}   funded</label>";
		
	$html .= "<progress name=\"progress\" value={$percent_value} max=\"100\">{$percent}</progress>";

	$html .= "</div>";

	$html .= "<a class=\"link\" href=\"https://invest.kuflink.co.uk\"> sign up </a>";

    $html .= "</div></div></div></div>";

}

    $html .= "</div>";

return $html;
}

// investor_terms_conditions
function investor_terms_conditions()
{
 return file_get_contents('https://s3.eu-west-2.amazonaws.com/terms-of-agreement/investor-terms-conditions.html');
}


//user agreement 
function user_agreement($atts, $content = null)
{

 return file_get_contents('https://s3.eu-west-2.amazonaws.com/terms-of-agreement/user-agreement.html');

}

//gdpragreement 
function gdpr_statement($atts, $content = null)
{

 return file_get_contents('https://terms-of-agreement.s3.eu-west-2.amazonaws.com/gdpr-statement.html');

}

//risk_warnings
function risk_warnings($atts, $content = null)
{

 return file_get_contents('https://terms-of-agreement.s3.eu-west-2.amazonaws.com/risk-warnings.html');

}

//risk_warnings for mobile
function risk_warnings_small($atts, $content = null)
{

 return file_get_contents('https://terms-of-agreement.s3.eu-west-2.amazonaws.com/risk-warnings-for_mobile.html');

}

//Detail risk_warnings
function detail_risk_warnings($atts, $content = null)
{

 return file_get_contents('https://terms-of-agreement.s3.eu-west-2.amazonaws.com/understand%20the%20risks');

}

//privacy_policy
function privacy_policy($atts, $content = null)
{

 return file_get_contents('https://terms-of-agreement.s3.eu-west-2.amazonaws.com/privacy-policy.html');

}


// Shortcodes
add_shortcode('total_amount', 'stats_amount');
add_shortcode('total_investment', 'stats_investment');
add_shortcode('deals', 'deals_shortcode');
add_shortcode('investor_terms_conditions', 'investor_terms_conditions');
add_shortcode('user_agreement', 'user_agreement');
add_shortcode('gdpr_statement', 'gdpr_statement');
add_shortcode('risk_warnings', 'risk_warnings');
add_shortcode('risk_warnings_small', 'risk_warnings_small');
add_shortcode('detail_risk_warnings', 'detail_risk_warnings');
add_shortcode('privacy_policy', 'privacy_policy');
