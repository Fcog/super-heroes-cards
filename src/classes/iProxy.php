<?php

namespace Superheroes;

/**
 * All proxies should implemwent this methods.
 */
interface iProxy {
    public function search_by_name( string $id );
    public function get_name( string $id );
    public function get_image( string $id );
    public function get_strength( string $id );
    public function get_power( string $id );
    public function get_combat( string $id );
    public function get_biography( string $id );
}