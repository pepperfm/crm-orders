<?php

declare(strict_types=1);

namespace App\Providers;

use Filament\Actions\StaticAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryContract;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryContract;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryContract;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryContract;

class AppServiceProvider extends ServiceProvider
{
    protected array $repositories = [
        OrderRepositoryContract::class => OrderRepository::class,
        ProductRepositoryContract::class => ProductRepository::class,
        CategoryRepositoryContract::class => CategoryRepository::class,
        UserRepositoryContract::class => UserRepository::class,
    ];

    public function register(): void
    {
        \Illuminate\Support\Carbon::setLocale(config('app.locale'));

        foreach ($this->repositories as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
    }

    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        Model::unguard();
        Model::shouldBeStrict($this->app->isLocal());

        $this->configureFilament();
    }

    protected function configureFilament(): void
    {
        Select::configureUsing(
            static fn(Select $select) => $select->searchDebounce(500)->native(false)
        );
        SelectFilter::configureUsing(
            static fn(SelectFilter $select) => $select->native(false)
        );
        DatePicker::configureUsing(
            static fn(DatePicker $datePicker) => $datePicker->native(false)
        );
        Column::configureUsing(
            static fn(Column $column) => $column
                ->placeholder('-')
                ->searchable(isIndividual: true, isGlobal: false)
        );

        Section::configureUsing(static fn(Section $section) => $section->maxWidth('xl'));

        CreateAction::configureUsing(static fn(CreateAction $action) => $action->createAnother(false));
        EditAction::configureUsing(static fn(EditAction $action) => $action->iconButton());
        ViewAction::configureUsing(static fn(ViewAction $action) => $action->iconButton());
        DeleteAction::configureUsing(
            static fn(DeleteAction $action) => $action
                ->iconButton()
                ->requiresConfirmation()
                ->modalHeading('Подтвердите действие')
                ->modalCancelAction(static fn(StaticAction $action) => $action->label('Нет'))
                ->modalSubmitAction(static fn(StaticAction $action) => $action->label('Да'))
                ->modalIcon('heroicon-o-trash')
        );

        Table::configureUsing(
            static fn(Table $table) => $table
                ->striped()
                ->paginated([10, 25, 50, 100])
                ->deferLoading()
                ->emptyStateHeading('Нет записей')
                ->defaultSort('created_at', 'desc')
        );
    }
}
