<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use App\Enums\OrderStatusEnum;
use App\Filament\Resources\OrderResource\Pages;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Select::make('user_id')
                            ->label('Покупатель')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('product_id')
                            ->label('Продукт')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('status')
                            ->label('Статус')
                            ->options(OrderStatusEnum::class)
                            ->default(OrderStatusEnum::New->value)
                            ->selectablePlaceholder(false)
                            ->required(),

                        Forms\Components\DatePicker::make('created_at')
                            ->displayFormat('d.m.Y')
                            ->disabled()
                            ->readonly(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->date('d.m.Y')
                    ->searchable(false),
                TextColumn::make('user.name')
                    ->label('Покупатель'),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->searchable(false)
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label('Покупатель')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('product_id')
                    ->label('Продукт')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Подтвердите действие')
                    ->modalIcon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
