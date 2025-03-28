<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Stock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Repeater::make('saleItems') // ✅ Allow multiple products
                ->relationship('saleItems')
                ->schema([
                    // ✅ Step 1: Select Product
                    Forms\Components\Select::make('product_id')
                        ->label('Select Product')
                        ->relationship('stock.product', 'name') // Show product names
                        ->preload()
                        ->required()
                        ->searchable()
                        ->columnSpan(12)
                        ->reactive(),

                    // ✅ Step 2: Select Batch (Only Batches for Selected Product)
                    Forms\Components\Select::make('stock_id')
                        ->label('Select Batch')
                        ->options(fn (callable $get) => 
                            Stock::where('product_id', $get('product_id'))
                                ->where('quantity', '>', 0)
                                ->get()
                                ->mapWithKeys(fn ($stock) => [
                                    $stock->id => 'Batch: ' . $stock->batch_name . ' | ₹' . $stock->purchase_price . ' (' . $stock->quantity . ' left)',
                                ])
                        )
                        ->preload()
                        ->required()
                        ->columnSpan(12)

                        ->reactive()
                        ->afterStateUpdated(fn (callable $set, callable $get) => 
                            $set('price', Stock::find($get('stock_id'))?->purchase_price)
                        ),

                    // ✅ Step 3: Price per Unit (Auto-Filled)
                    Forms\Components\TextInput::make('price')
                        ->label('Price per Unit')
                        ->numeric()
                        ->columnSpan(5)
                        ->disabled()
                        ->dehydrated(),

                    // ✅ Step 4: Quantity Input
                    Forms\Components\TextInput::make('quantity')
                        ->label('Quantity')
                        ->numeric()
                        ->required()
                        ->columnSpan(5)

                        ->reactive()
                        ->afterStateUpdated(fn (callable $set, callable $get) => 
                            $set('total_price', $get('quantity') * $get('price'))
                        ),

                    // ✅ Step 5: Total Price (Auto-Filled)
                    Forms\Components\TextInput::make('total_price')
                        ->label('Total Price')
                        ->numeric()
                        ->disabled()
                        ->columnSpan(5)

                        ->dehydrated(),
                ])
                ->columns(5)
                ->defaultItems(1), // Starts with one product selection

            // ✅ Display Total Products Count
            Forms\Components\TextInput::make('total_products')
                ->label('Total Products Added')
                ->numeric()
                ->disabled()
                ->dehydrated()
                ->reactive()
                ->afterStateUpdated(fn (callable $set, callable $get) => 
                    $set('total_products', count($get('saleItems') ?? []))
                ),

            // ✅ Display Total Amount Calculation
          // ✅ Display Total Amount Calculation
          Forms\Components\TextInput::make('total_price')
          ->label('Overall Total Price')
          ->numeric()
          ->disabled()
          ->reactive()
          ->afterStateUpdated(fn (callable $set, callable $get) => 
              $set('total_price', collect($get('saleItems') ?? [])
                  ->sum(fn ($item) => ($item['total_price'] ?? 0)) // Summing all total_price values
              )
          )
      

        
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->label('Sale ID'),
            Tables\Columns\TextColumn::make('total_price')->label('Total Price')->sortable(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
