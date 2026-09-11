<?php

declare(strict_types=1);

namespace Elfeffe\Medialibrary\Support;

/**
 * Reads a stored media-library selection (form state, a model's meta, a config array) as ids.
 * Lives outside Forms so a model can use it without reaching for a Filament component.
 */
final class MediaIds
{
    /**
     * @return list<int>
     */
    public static function normalize(mixed $state): array
    {
        if (! is_array($state)) {
            return [];
        }

        return array_values(array_unique(array_map(
            'intval',
            array_filter($state, static fn (mixed $id): bool => is_numeric($id) && (int) $id > 0),
        )));
    }
}
