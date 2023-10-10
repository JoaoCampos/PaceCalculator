<?php

/*
* Plugin Name:       AMC :: Running Pace Calculator
* Plugin URI:        https://aminhacorrida.com
* Description:       Plugin for race pace calculation, based on https://github.com/alterebro/PaceCalculator
* Version:           1.0.0
* Author:            João Campos
* Author URI:        https://joaocampos.com
* Text Domain:       amc-pace-calculator
* Domain Path:       /languages
* Notes:             
* 
*/

/* ******************************************************************************************************************************************** */

add_shortcode( 'render-amc-running-pace-calculator', 'render_amc_running_pace_calculator' );
function render_amc_running_pace_calculator() {

    $output = '';

    

    $output .= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />';
	$output .= '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" />';
	

    /*
    Descubra o ritmo médio da sua corrida, calcule a distância percorrida com base no ritmo estimado e planeie o seu treino ou prova usando esta calculadora para determinar o ritmo para percorrer uma determinada distância.
    <br/>
    Basta inserir dois dos três campos variáveis (ritmo, tempo, distância) e pressionar o botão correspondente ao terceiro para calcular o valor.

    <option value="26.21875-M">Maratona</option>
    <option value="13.109375-M">Meia-maratona</option>

    */
    
    $output .= '
    
    <!-- -->
    <section role="main">

        
        <form id="pace-calculator-form">
            <dl>
                <dt><i class="fa fa-fw fa-clock-o"></i> <strong>Tempo</strong></dt>
                <dd class="time-input">
                    <span>
                        <label for="time-hours">Horas</label>
                        <input type="number" name="time-hours" id="time-hours" maxlength="2" placeholder="hh" step="1" min="0" max="99" />
                    </span>
                    <span>
                        <label for="time-minutes">Minutos</label>
                        <input type="number" name="time-minutes" id="time-minutes" maxlength="2" placeholder="mm" step="1" min="0" max="59" />
                    </span>
                    <span>
                        <label for="time-seconds">Segundos</label>
                        <input type="number" name="time-seconds" id="time-seconds" maxlength="6" placeholder="ss" step="1" min="0" max="59" />
                    </span>
                </dd>
                <dd>
                    <p>Para calcular o seu tempo, preencha a distância e pace e clique aqui.</p>
                    <button id="calculate-time">Time <i class="fa fa-chevron-right"></i></button>
                </dd>

                <dt><i class="fa fa-fw fa-road"></i> <strong>Distância</strong></dt>
                <dd class="distance-input">
                    <div>
                        <span class="double-w">
                            <label for="distance-amount">Distância</label>
                            <input type="number" name="distance-amount" id="distance-amount" maxlength="8" step="any" min="0" />
                        </span>
                        <span>
                            <label for="distance-unit">Unidade</label>
                            <select name="distance-unit" id="distance-unit">
                                <option value="Mile">Milhas</option>
                                <option value="Kilometer" selected="selected">Quilómetros</option>
                                <option value="Meter">Metros</option>
                            </select>
                        </span>
                    </div>
                    <div class="separator-or"> &mdash; or &mdash; </div>
                    <div class="event-input">
                        <select name="event-select" id="event-select" class="triple-w">
                            <option value="false">Escolha uma distância pré-definida</option>
                            <option value="42.195-K">Maratona</option>
                            <option value="21.0975-K">Meia-maratona</option>
                            <option value="20-K">20Km</option>
                            <option value="15-K">15Km</option>
                            <option value="10-K">10Km</option>
                            <option value="5-K">5Km</option>
                        </select>
                    </div>
                </dd>
                <dd>
                    <p>Para calcular a distância, preencha o tempo e o pace e depois clique aqui.</p>
                    <button id="calculate-distance">Distância <i class="fa fa-chevron-right"></i></button>
                </dd>

                <dt><i class="fa fa-fw fa-bolt"></i> <strong>Pace</strong></dt>
                <dd class="pace-input">
                    <span>
                        <label for="pace-minutes">Minutos</label>
                        <input type="number" name="pace-minutes" id="pace-minutes" maxlength="2" placeholder="mm" min="0" max="59"  />
                    </span>
                    <span>
                        <label for="pace-seconds">Segundos</label>
                        <input type="number" name="pace-seconds" id="pace-seconds" maxlength="6" placeholder="ss" min="0" max="60"  />
                    </span>
                    <span>
                        <label for="pace-unit">/ Por</label>
                        <select name="pace-unit" id="pace-unit">
                            <option value="Kilometer" selected="selected">Km</option>
                            <option value="Mile">Milha</option>
                        </select>
                    </span>
                </dd>
                <dd>
                    <p>Para calcular o seu pace, preencha o tempo e a distância e depois clique aqui.</p>
                    <button id="calculate-pace">Pace <i class="fa fa-chevron-right"></i></button>
                </dd>
            </dl>
        </form>

    </section>

    <div id="modal-window">
        <div class="modal-notice">
            <p id="modal-error"></p>
            <dl id="modal-info">
                <dt><dfn>Tempo</dfn></dt>
                <dd id="modal-info-time">--</dd>
                <dt><dfn>Distância</dfn></dt>
                <dd id="modal-info-distance">--</dd>
                <dt><dfn>Pace</dfn></dt>
                <dd id="modal-info-pace">--</dd>
            </dl>
            <p><button id="modal-alright">Ok</button></p>
        </div>
    </div>
    <!-- -->
    
    ';

    
    return $output;

}

function enqueue_amc_running_pace_calculator_css() {
    $plugin_url = plugins_url('/', __FILE__);
    $css_path = $plugin_url . 'css/pacecalculator.css';
    wp_enqueue_style('amc-running-pace-calculator-css', $css_path);
}
// add_action('wp_enqueue_scripts', 'enqueue_amc_running_pace_calculator_css');

function enqueue_amc_running_pace_calculator_js() {
    $plugin_url = plugins_url('/', __FILE__);
    $js_path = $plugin_url . 'js/pacecalculator.min.js';
    wp_enqueue_script('amc-running-pace-calculator-js', $js_path, array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_amc_running_pace_calculator_js');

function add_custom_js() {
    ?>
    <script>
        paceCalculator.init();
    </script>
    <?php
}

// Hook the function to the wp_footer action
add_action('wp_footer', 'add_custom_js', 9999);