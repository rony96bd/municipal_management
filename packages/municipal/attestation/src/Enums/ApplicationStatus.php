<?php

namespace Municipal\Attestation\Enums;

enum ApplicationStatus: string
{
    case Pending = 'pending';
    case UnderReview = 'under_review';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Issued = 'issued'; // printed and handed over at the office

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'অপেক্ষমান',
            self::UnderReview => 'যাচাই চলছে',
            self::Approved => 'অনুমোদিত',
            self::Rejected => 'বাতিল',
            self::Issued => 'হস্তান্তরিত',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::UnderReview => 'info',
            self::Approved => 'success',
            self::Rejected => 'danger',
            self::Issued => 'secondary',
        };
    }

    /** @return list<self> statuses an application may move to from this one */
    public function next(): array
    {
        return match ($this) {
            self::Pending => [self::UnderReview, self::Approved, self::Rejected],
            self::UnderReview => [self::Approved, self::Rejected, self::Pending],
            self::Approved => [self::Issued, self::UnderReview],
            self::Rejected => [self::Pending],
            self::Issued => [],
        };
    }

    public function canMoveTo(self $to): bool
    {
        return in_array($to, $this->next(), true);
    }
}
