<?php

declare(strict_types=1);

namespace App\Data\Order\Responses;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\LoadRelation;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;
use Carbon\Carbon;
use App\Enums\OrderStatusEnum;
use App\Data\User\UserData;

class IndexResponse extends Data
{
    public function __construct(
        public int $id,
        #[MapName('created_at'), WithTransformer(DateTimeInterfaceTransformer::class, format: 'd.m.Y')]
        public Carbon $createdAt,
        #[LoadRelation]
        public UserData $user,
        public OrderStatusEnum $status,
        #[MapName('status_label')]
        public ?string $statusLabel = null,
    ) {
        $this->statusLabel = $this->status->getLabel();
    }
}
