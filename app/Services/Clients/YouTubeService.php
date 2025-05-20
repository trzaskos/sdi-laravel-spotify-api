<?php

namespace App\Services\Clients;

use App\DataTransferObjects\AlbumDTO;
use App\DataTransferObjects\ArtistDTO;
use App\DataTransferObjects\PlaylistDTO;
use App\DataTransferObjects\TrackDTO;
use App\Enums\MusicSource;
use App\Services\Contracts\MusicServiceInterface;
use App\Services\Shared\BaseMusicServiceWithToken;

class YouTubeService extends BaseMusicServiceWithToken implements MusicServiceInterface
{
    public function __construct()
    {
        parent::__construct(MusicSource::YOUTUBE);
    }

    public function searchArtist(string $query): array
    {
        return [
            ArtistDTO::fromYouTube([
                'id' => 'yt_artist_1',
                'name' => 'YouTube Artist One',
                'popularity' => 70,
                'genres' => [],
                'image' => null,
            ]),
            ArtistDTO::fromYouTube([
                'id' => 'yt_artist_2',
                'name' => 'YouTube Artist Two',
                'popularity' => 87,
                'genres' => [],
                'image' => null,
            ]),
        ];
    }

    public function getPlaylist(string $id): PlaylistDTO
    {
        return PlaylistDTO::fromYouTube([
            'id' => $id,
            'name' => 'YouTube Playlist',
            'description' => 'Mocked description',
            'image' => null,
            'tracks' => []
        ]);
    }

    public function searchTrack(string $query): array
    {
        return [
            TrackDTO::fromYouTube([
                'id' => 'yt_track_1',
                'name' => 'Track One',
                'albumName' => 'YT Track',
                'artists' => [],
                'durationMs' => 1,
                'previewUrl' => null,
                'image' => null,
            ]),
            TrackDTO::fromYouTube([
                'id' => 'yt_track_2',
                'name' => 'Track Two',
                'albumName' => 'Album One',
                'artists' => [],
                'durationMs' => 1,
                'previewUrl' => null,
                'image' => null,
            ]),
        ];
    }

    public function getTrack(string $id): TrackDTO
    {
        return TrackDTO::fromYouTube([
            'id' => $id,
            'name' => 'YouTube Track',
            'albumName' => 'Album Two',
            'artists' => [],
            'durationMs' => 1,
            'previewUrl' => null,
            'image' => null,
        ]);
    }

    public function getAlbumsByArtist(string $artistId): array
    {
        return [
            AlbumDTO::fromYouTube([
                'id' => 'yt_album_1',
                'name' => 'Album One',
                'release_date' => null,
                'artists' => ['Mocked Artist'],
                'image' => null,
            ]),
            AlbumDTO::fromYouTube([
                'id' => 'yt_album_2',
                'name' => 'Album Two',
                'release_date' => null,
                'artists' => ['Mocked Artist'],
                'image' => null,
            ]),
        ];
    }

    public function getTopTracksByArtist(string $artistId): array
    {
        return [
            TrackDTO::fromYouTube([
                'id' => 'yt_track_1',
                'name' => 'Top Track One',
                'albumName' => 'Album One',
                'artists' => [],
                'durationMs' => 1,
                'previewUrl' => null,
                'image' => null,
            ]),
            TrackDTO::fromYouTube([
                'id' => 'yt_track_2',
                'name' => 'Top Track Two',
                'albumName' => 'Album Two',
                'artists' => [],
                'durationMs' => 1,
                'previewUrl' => null,
                'image' => null,
            ]),
        ];
    }
}
