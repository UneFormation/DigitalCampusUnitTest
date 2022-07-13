<?php

namespace App\Entity;

class Invoice
{
    const DEFAULT_VAT_PERCENT = 0.20;

    public string $name;

    protected float $amount;

    protected float $vatAmount;

    protected float $totalAmount;

    private Tax $tax;

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param float $amount
     * @return $this
     */
    public function setAmount(float $amount): static
    {
        $this->amount = round($amount, 2);
        if (isset($this->tax)) {
            $this->computeTaxAmount();
        }

        return $this;
    }

    /**
     * @param Tax $tax
     * @return $this
     */
    public function setTax(Tax $tax): static
    {
        $this->tax = $tax;
        if (isset($this->amount)) {
            $this->computeTaxAmount();
        }

        return $this;
    }

    /**
     * @return float
     */
    public function getVatAmount(): float
    {
        return $this->vatAmount ?? 0.0;
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        return $this->totalAmount ?? 0.0;
    }

    /**
     * @return void
     */
    private function computeTaxAmount(): void
    {
        $this->vatAmount = $this->tax->applyOnAmount($this->amount);
        $this->totalAmount = round($this->amount + $this->vatAmount, 2);
    }
}