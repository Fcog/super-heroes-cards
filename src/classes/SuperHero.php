<?php

namespace Superheroes;

/**
 * Super Hero entity.
 */
class SuperHero {
    private $proxy;
    private $id;
    
    /**
     * __construct
     *
     * @param  iProxy $proxy
     * @param  string $name
     * @return void
     */
    public function __construct( iProxy $proxy, string $name ) {
        try {
            $this->proxy = $proxy;
            $this->id = $proxy->search_by_name( $name );
        } catch ( \Exception $e ) {
            // TODO: write to log.
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    
    /**
     * get_name
     *
     * @return string
     */
    public function get_name() : string {
        if ( ! $this->id ) {
            return '';
        }

        return $this->proxy->get_name( $this->id );
    }
    
    /**
     * get_image
     *
     * @return string
     */
    public function get_image() : string {
        if ( ! $this->id ) {
            return '';
        }

        return $this->proxy->get_image( $this->id );
    }    
    
    /**
     * get_strength
     *
     * @return string
     */
    public function get_strength() : string {
        if ( ! $this->id ) {
            return '';
        }

        return $this->proxy->get_strength( $this->id );
    }        
       
    /**
     * get_power
     *
     * @return string
     */
    public function get_power() : string {
        if ( ! $this->id ) {
            return '';
        }

        return $this->proxy->get_power( $this->id );
    }
     
    /**
     * get_weapons
     *
     * @return string
     */
    public function get_weapons() : string {
        if ( ! $this->id ) {
            return '';
        }

        return $this->proxy->get_combat( $this->id );
    }

    /**
     * get_biography
     *
     * @return string
     */
    public function get_biography() : string {
        if ( ! $this->id ) {
            return '';
        }

        return $this->proxy->get_biography( $this->id );
    }
}