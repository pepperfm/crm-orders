<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Назад')
                ->color('primary')
                ->icon('heroicon-m-arrow-left-circle')
                ->url(static fn(): string => back()->getTargetUrl()),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $sum = \App\Models\Product::query()->where('id', $data['product_id'])->value('price');
        data_set($data, 'sum', $sum);

        return parent::handleRecordUpdate($record, $data);
    }
}
