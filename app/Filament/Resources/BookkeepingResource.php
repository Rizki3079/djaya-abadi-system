<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookkeepingResource\Pages;
use App\Models\Bookkeeping;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use App\Models\Outlet;
use Filament\Forms\Get;
use Filament\Forms\Set;

class BookkeepingResource extends Resource
{
    protected static ?string $model = Bookkeeping::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pembukuan';

    protected static ?string $navigationGroup = 'Pembukuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('bookkeeping_date')
                    ->label('Tanggal Pembukuan')
                    ->required()
                    ->default(now()),

                Forms\Components\Select::make('outlet_id')
                    ->label('Outlet')
                    ->relationship('outlet', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function ($state, Set $set) {

                        if (!$state) {
                            $set('incomeItems', []);
                            $set('paymentItems', []);
                            return;
                        }

                        $outlet = Outlet::find($state);

                        if (!$outlet) {
                            return;
                        }

                        $set(
                            'incomeItems',
                            $outlet->getIncomeItemsTemplate()
                        );

                        $set(
                            'paymentItems',
                            $outlet->getPaymentItemsTemplate()
                        );

                    })
                    ->required(),

                Forms\Components\Placeholder::make('income_preview')
                    ->label('Preview Income Category')
                    ->content(function (Forms\Get $get) {

                        if (!$get('outlet_id')) {
                            return 'Pilih outlet terlebih dahulu';
                        }

                        $outlet = \App\Models\Outlet::with('incomeCategories')
                            ->find($get('outlet_id'));

                        if (!$outlet) {
                            return '-';
                        }

                        return $outlet->incomeCategories
                            ->pluck('name')
                            ->implode(', ');
                    })
                    ->live(),    

                Forms\Components\Placeholder::make('payment_preview')
                    ->label('Preview Payment Method')
                    ->content(function (Forms\Get $get) {

                        if (!$get('outlet_id')) {
                            return 'Pilih outlet terlebih dahulu';
                        }

                        $outlet = \App\Models\Outlet::with('paymentMethods')
                            ->find($get('outlet_id'));

                        if (!$outlet) {
                            return '-';
                        }

                        return $outlet->paymentMethods
                            ->pluck('name')
                            ->implode(', ');
                    })
                    ->live(),

                Forms\Components\Select::make('user_id')
                    ->label('Kasir')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Section::make('Pendapatan')
                    ->schema([
                        Repeater::make('incomeItems')
                            ->relationship()
                            ->schema([
                                TextInput::make('name')
                                    ->label('Kategori')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required(),

                                TextInput::make('amount')
                                    ->label('Nominal')
                                    ->numeric()
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        self::recalculateTotals($get, $set);
                                    })
                                    ->required(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->collapsible(false),
                    ]),

                Section::make('Pembayaran Non Tunai')
                    ->schema([
                        Repeater::make('paymentItems')
                            ->relationship()
                            ->schema([
                                TextInput::make('method_name')
                                    ->label('Metode Pembayaran')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required(),

                                TextInput::make('amount')
                                    ->label('Nominal')
                                    ->numeric()
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        self::recalculateTotals($get, $set);
                                    })
                                    ->required(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->collapsible(false),
                    ]),

                Section::make('Pengeluaran')
                    ->schema([
                        Repeater::make('expenseItems')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('expense_vendor_id')
                                    ->label('Vendor')
                                    ->relationship('expenseVendor', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                TextInput::make('invoice_number')
                                    ->label('No Invoice'),

                                Forms\Components\DatePicker::make('invoice_date')
                                    ->label('Tanggal Invoice'),

                                Forms\Components\Select::make('payment_status')
                                    ->label('Status Pembayaran')
                                    ->options([
                                        'lunas' => 'Lunas',
                                        'cicilan' => 'Cicilan',
                                    ])
                                    ->default('lunas')
                                    ->required(),

                                Forms\Components\Textarea::make('description')
                                    ->label('Keterangan'),

                                TextInput::make('amount')
                                    ->label('Nominal')
                                    ->numeric()
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        self::recalculateTotals($get, $set);})
                                    ->required(),
                            ])
                            ->columns(2)
                            ->defaultItems(0),
                    ]),

                Forms\Components\TextInput::make('tax')
                    ->label('Pajak')
                    ->numeric()
                    ->live(debounce: 500)
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::recalculateTotals($get, $set);
                    })
                    ->default(0),

                Forms\Components\TextInput::make('service')
                    ->label('Service')
                    ->numeric()
                    ->live(debounce: 500)
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::recalculateTotals($get, $set);
                    })
                    ->default(0),

                Forms\Components\TextInput::make('owner_note_amount')
                    ->label('Nota Owner')
                    ->numeric()
                    ->live(debounce: 500)
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::recalculateTotals($get, $set);
                    })
                    ->default(0),

                Forms\Components\Textarea::make('notes')
                    ->label('Catatan')
                    ->columnSpanFull(),

                Section::make('Ringkasan')
                    ->schema([
                        TextInput::make('total_income')
                            ->label('Total Pendapatan')
                            ->disabled(),

                        TextInput::make('total_non_cash')
                            ->label('Total Non Tunai')
                            ->disabled(),

                        TextInput::make('total_expense')
                            ->label('Total Pengeluaran')
                            ->disabled(),

                        TextInput::make('cash_on_hand')
                            ->label('Cash On Hand')
                            ->disabled(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bookkeeping_date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('outlet.name')
                    ->label('Outlet')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Kasir')
                    ->searchable(),

                Tables\Columns\TextColumn::make('total_income')
                    ->label('Total Pendapatan')
                    ->money('IDR'),

                Tables\Columns\TextColumn::make('total_non_cash')
                    ->label('Non Tunai')
                    ->money('IDR'),

                Tables\Columns\TextColumn::make('total_expense')
                    ->label('Pengeluaran')
                    ->money('IDR'),    

                Tables\Columns\TextColumn::make('cash_on_hand')
                    ->label('Cash On Hand')
                    ->money('IDR'),

                Tables\Columns\TextColumn::make('created_at')
                    ->since(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static function recalculateTotals(Get $get, Set $set): void
    {
        // Net Sales (Food + Drink + Add On + dst)
        $netSales = collect($get('incomeItems'))
            ->sum(fn ($item) => (float) ($item['amount'] ?? 0));

        // Pajak
        $tax = (float) ($get('tax') ?? 0);

        // Service
        $service = (float) ($get('service') ?? 0);

        // Total Pendapatan (Gross)
        $totalIncome = $netSales + $tax + $service;

        // Non Tunai
        $totalNonCash = collect($get('paymentItems'))
            ->sum(fn ($item) => (float) ($item['amount'] ?? 0));

        // Pengeluaran
        $totalExpense = collect($get('expenseItems'))
            ->sum(fn ($item) => (float) ($item['amount'] ?? 0));

        // Nota Owner
        $ownerNote = (float) ($get('owner_note_amount') ?? 0);

        $set('total_income', $totalIncome);
        $set('total_non_cash', $totalNonCash);
        $set('total_expense', $totalExpense);

        $set(
            'cash_on_hand',
            $totalIncome
            - $totalNonCash
            - $totalExpense
            - $ownerNote
        );
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
            'index' => Pages\ListBookkeepings::route('/'),
            'create' => Pages\CreateBookkeeping::route('/create'),
            'edit' => Pages\EditBookkeeping::route('/{record}/edit'),
        ];
    }
}
