<?php

namespace Superheroes;

/**
 * Init plugin.
 */
class App {
    public $proxy;
    public $root_dir;
    
    /**
     * Initialize API client.
     *
     * @param  mixed $root_dir The plugin's root directory path.
     * @return void
     */
    public function __construct( $root_dir ) {
        // TODO: get token from plugin's settings page.
        $token = '2890181287905675';

        $client = new \GuzzleHttp\Client([
            'base_uri' => 'https://superheroapi.com/api/' . $token . '/',
        ]);

        $this->proxy = new SuperHeroesAPI( $client );
        $this->root_dir = $root_dir;
    }
    
    /**
     * Add CSS.
     *
     * @return void
     */
    public function insert_assets() {
        add_action('wp_enqueue_scripts', function() {
            wp_enqueue_style( 'superheroes-plugin', plugins_url( 'src/public/styles.css', $this->root_dir ), false, '1.0.0', 'all' );
        });
    }
    
    /**
     * Creates the shotcode and HTML.
     *
     * @return void
     */
    public function create_shortcode() {
        add_shortcode('superhero-card', function( $atts ) {
            $hero_name = $atts['hero'] ?? ''; 

            $superhero = new SuperHero( $this->proxy, $hero_name );

            if ( ! $superhero->get_name() ) {
                return '';
            }

            ob_start();
            ?>

            <div class="superheroes-card">
                <h3 class="superheroes-card__title"><?php echo esc_html( $superhero->get_name() ); ?></h3>
                <img src="<?php echo esc_url( $superhero->get_image() ); ?>"">
                <div class="superheroes-card__stats">
                    <div class="superheroes-card__stats__line superheroes-card--red">PHYSICAL STRENGTH: <?php echo esc_html( $superhero->get_strength() ); ?></div>
                    <div class="superheroes-card__stats__line">SPECIAL POWERS: <?php echo esc_html( $superhero->get_power() ); ?></div>
                    <div class="superheroes-card__stats__line superheroes-card--blue">WEAPONS: <?php echo esc_html( $superhero->get_weapons() ); ?></div>
                </div>
                <div class="superheroes-card__bio">Place of birth: <?php echo esc_html( $superhero->get_biography() ); ?></div>
            </div>

            <?php
            return ob_get_clean();
        }); 
    }
}
