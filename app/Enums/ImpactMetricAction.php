<?php

namespace App\Enums;

use App\Models\CapabilityRequirementMatch;
use Illuminate\Support\Facades\Auth;

enum ImpactMetricAction
{

    public static function allowedForAdmin(): array
    {
        return [
            'scientific_technological' => true,
            'economic' => true,
            'institutional' => true,
            'social_environmental' => true,
            'perception_satisfaction' => true,
            'public_innovation' => true,
        ];
    }

    public static function allowed(CapabilityRequirementMatch $capabilityRequirementMatch): array
    {
        $user = Auth::user();
        $role = self::resolveActor($capabilityRequirementMatch, $user);
        if ($role === null) return [];

        $offererType = self::normalize($capabilityRequirementMatch->capability->getOwnerCode());
        $applicantType = self::normalize($capabilityRequirementMatch->requirement->getOwnerCode());

        $base = self::getBaseRules($role, $offererType, $applicantType);

        $contextualRules = self::getContextualRules($role, $offererType, $applicantType);

        return array_merge($base, $contextualRules);
    }

    private static function getContextualRules(string $role, string $offererType, string $applicantType): array
    {
        $contextualRules = self::contextualRules();

        foreach ($contextualRules as $rule) {
            if (
                $rule['role'] === $role &&
                $rule['offerer'] === $offererType &&
                $rule['applicant'] === $applicantType
            ) {
                return $rule['overrides'];
            }
        }

        return [];
    }

    private static function getBaseRules(string $role, string $offererType, string $applicantType): array
    {
        $rules = self::rules();

        return $role === 'offerer'
            ? ($rules['offerer'][$offererType] ?? [])
            : ($rules['applicant'][$applicantType] ?? []);
    }

    private static function contextualRules(): array
    {
        return [
            [
                'role' => 'offerer',
                'offerer' => 'institution',
                'applicant' => 'government',
                'overrides' => [
                    'public_innovation' => true,
                ],
            ],

            [
                'role' => 'offerer',
                'offerer' => 'institution',
                'applicant' => 'nonprofit',
                'overrides' => [
                    'social_environmental' => true,
                ],
            ],
        ];
    }

    private static function normalize(string $code): string
    {
        return match ($code) {
            'IES', 'CI' => 'institution',
            'ebt' => 'company',
            'gob' => 'government',
            'ong' => 'nonprofit',
            default => 'unknown',
        };
    }

    private static function rules(): array
    {
        return [
            'offerer' => [
                'institution' => [
                    'scientific_technological' => true,
                    'economic' => false,
                    'institutional' => true,
                    'social_environmental' => false,
                    'perception_satisfaction' => true,
                    'public_innovation' => false,
                ],
            ],

            'applicant' => [
                'company' => [
                    'scientific_technological' => false,
                    'economic' => true,
                    'institutional' => false,
                    'social_environmental' => true,
                    'perception_satisfaction' => true,
                    'public_innovation' => false,
                ],

                'government' => [
                    'scientific_technological' => false,
                    'economic' => false,
                    'institutional' => false,
                    'social_environmental' => true,
                    'perception_satisfaction' => true,
                    'public_innovation' => true,
                ],

                'nonprofit' => [
                    'scientific_technological' => false,
                    'economic' => false,
                    'institutional' => false,
                    'social_environmental' => true,
                    'perception_satisfaction' => true,
                    'public_innovation' => false,
                ],

                'institution' => [
                    'scientific_technological' => true,
                    'economic' => false,
                    'institutional' => true,
                    'social_environmental' => false,
                    'perception_satisfaction' => true,
                    'public_innovation' => false,
                ],
            ],
        ];
    }

    private static function resolveActor(CapabilityRequirementMatch $capabilityRequirementMatch): ?string
    {
        $user = Auth::user();

        return match (true) {
            $capabilityRequirementMatch->isOfferer($user) => 'offerer',
            $capabilityRequirementMatch->isApplicant($user) => 'applicant',
            default => null,
        };
    }
}
