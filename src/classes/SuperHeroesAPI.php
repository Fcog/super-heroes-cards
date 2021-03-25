<?php

namespace Superheroes;

/**
 * Connection with the SuperHero API and gathering of data. 
 */
class SuperHeroesAPI implements iProxy {
    private $client;
    
    /**
     * __construct
     *
     * @param  mixed $client
     * @return void
     */
    public function __construct( $client ) {
        $this->client = $client;
    }

    /**
     * Get the response body of the request and decode it into an object.
     *
     * @param  object $response The API response
     * @return object The decoded body content.
     */
    private function decode( object $response ) : object {
        return json_decode( $response->getBody()->getContents() );
    }

    private function get_results( string $args ) {
        $response = $this->decode( $this->client->request( 'GET', $args ) );

        if ( $response->response === 'error' ) {
            throw new \Exception( $response->error );
        }

        // Take care of special case when searching by name it returns the results in "results" property.
        return isset( $response->results ) ? $response->results : $response;
    }    

    /**
     * search_by_name
     *
     * @param  string name The superhero name.
     * @return string Return the hero ID.
     */
    public function search_by_name( string $name ) : string {
        $results = $this->get_results( 'search/' . $name );

        return empty( $results ) ? '' : $results[0]->id;
    }
    
    /**`
     * get_name
     *
     * @param  string $id The superhero ID.
     * @return string
     */
    public function get_name( string $id ) : string {
        $results = $this->get_results( $id );

        return $results->name;
    }
    
    /**
     * get_image
     *
     * @param  string $id The superhero ID.
     * @return string
     */
    public function get_image( string $id ) : string {
        $results = $this->get_results( $id . '/image' );

        return $results->url;
    }
    
    /**
     * get_powerstats
     *
     * @param  string $id The superhero ID.
     * @return object
     */
    private function get_powerstats( string $id ) : object {
        $results = $this->get_results( $id . '/powerstats' );
        
        return $results;        
    }
    
    /**
     * get_strength
     *
     * @param  string $id The superhero ID.
     * @return string
     */
    public function get_strength( string $id ) : string {
        return $this->get_powerstats( $id )->strength;
    }    
    
    /**
     * get_power
     *
     * @param  string $id The superhero ID.
     * @return string
     */
    public function get_power( string $id ) : string {
        return $this->get_powerstats( $id )->power;
    }        
    
    /**
     * get_combat
     *
     * @param  string $id The superhero ID.
     * @return string
     */
    public function get_combat( string $id ) : string {
        return $this->get_powerstats( $id )->combat;
    }          
    
    /**
     * get_biography
     *
     * @param  string $id The superhero ID.
     * @return string
     */
    public function get_biography( string $id ) : string {
        $results = $this->get_results( $id . '/biography' );

        return $results->{'place-of-birth'}; 
    }          
}