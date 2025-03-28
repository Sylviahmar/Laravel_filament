<?php
namespace App\Filament\Resources;

use App\Filament\Resources\StockResource\Pages;
use App\Models\Stock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Button;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\Relationship;
use Illuminate\Database\Eloquent\Relations\Relation;
use League\Uri\Idna\Option;
use Symfony\Contracts\Service\Attribute\Required;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form



            ->schema([
                Select::make('product_id')
                    ->default(0)
                    ->relationship('product', 'name')
                    ->required()
                    ->reactive(), // ✅ Detects changes instantly


                Select::make('batch_name')
                    ->label('Batch')
                    ->options([
                        'A' => 'batch A',
                        'B' => 'batch B',
                        'C' => 'batch C',
                        'D' => 'batch D',
                    ]),

                TextInput::make('quantity')
                    ->label('Quantity')
                    ->required(),

                TextInput::make('purchase_price')
                    ->label('Purchase price per unit')
                    ->required(),


                // Button to add more stocks // Allows entering multiple stock records
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product Name')
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity Available')
                    ->sortable(),

                Tables\Columns\TextColumn::make('batch_name')
                    ->label('Batch Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('purchase_price')
                    ->label('Purchase Price')
                    ->sortable()
                    ->money('INR'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date Added')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStocks::route('/'),
            'create' => Pages\CreateStock::route('/create'),
            'edit' => Pages\EditStock::route('/{record}/edit'),
        ];
    }
}
