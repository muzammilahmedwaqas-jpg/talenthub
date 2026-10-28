<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Invoice extends Model
{

    use HasFactory;

    protected $fillable = [
        'client_id',
        'service_id',
        'invoice_number',
        'issue_date',
        'due_date',
        'amount',
        'status',
    ];

    protected function casts(): array
    {
        return[
            'issue_date' => 'date',
            'due_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
    
    protected function totalPaid(): Attribute
    {
        return Attribute::get(fn () => round((float) $this->payments->sum('amount'), 2));
    }

    protected function balance(): Attribute
    {
        return Attribute::get(fn () => round((float) $this->amount - $this->total_paid, 2));
    }

    public function refreshStatus(): void
    {
        $this->load('payments');

        $this->status = match (true) {
            $this->balance <= 0 => 'paid',
            $this->total_paid > 0 => 'partial',
            default => 'unpaid',
        };

        $this->save();
    }

}
