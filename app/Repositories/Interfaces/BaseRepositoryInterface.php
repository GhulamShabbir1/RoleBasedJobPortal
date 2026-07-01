<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    /**
     * Create or update model using single manage method
     * If $id is null: creates new model
     * If $id is provided: finds and updates existing model
     *
     * @param array $data Model data
     * @param int|null $id Model ID (null for create, int for update)
     * @return object Created or updated model
     */
    public function manage(array $data, ?int $id = null): object;

    /**
     * Find model by ID
     *
     * @param int $id Model ID
     * @return object|null
     */
    public function findById(int $id): ?object;

    /**
     * Delete model by ID
     *
     * @param int $id Model ID
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Clear related cache
     *
     * @return void
     */
    public function clearCache(): void;
}
