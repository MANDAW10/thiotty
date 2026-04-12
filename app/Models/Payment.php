<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\AsCollection;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'amount',
        'payment_method',
        'status',
        'transaction_id',
        'gateway',
        'metadata',
        'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'metadata' => 'array',
            'processed_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Vérifier si le paiement est complété
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Vérifier si le paiement est en cours
     */
    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }

    /**
     * Vérifier si le paiement a échoué
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Marquer le paiement comme complété
     */
    public function markAsCompleted(?string $transactionId = null): void
    {
        $this->update([
            'status' => 'completed',
            'transaction_id' => $transactionId ?? $this->transaction_id,
            'processed_at' => now(),
        ]);

        // Mettre à jour le statut de la commande
        $this->order->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
        ]);
    }

    /**
     * Marquer le paiement comme échoué
     */
    public function markAsFailed(string $reason = ''): void
    {
        $this->update([
            'status' => 'failed',
            'metadata' => array_merge($this->metadata ?? [], ['failure_reason' => $reason]),
        ]);

        // Mettre à jour le statut de la commande
        $this->order->update(['payment_status' => 'failed']);
    }

    /**
     * Marquer le paiement comme en traitement
     */
    public function markAsProcessing(): void
    {
        $this->update(['status' => 'processing']);
        $this->order->update(['payment_status' => 'processing']);
    }
}
