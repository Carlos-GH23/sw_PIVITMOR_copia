<?php
namespace App\Traits;

use App\Models\EmailTemplate;
use Illuminate\Notifications\Messages\MailMessage;

trait ConstructEmailTemplate
{
    public function buildMailMessage(string $templateKey, array $variables = [])
    {
  
        $template = EmailTemplate::where('key', $templateKey)->first();

        if (!$template) {
            return;
        }

        $subject = str_replace(array_keys($variables), array_values($variables), $template->subject);
        $rawBody = str_replace(array_keys($variables), array_values($variables), $template->body);

        $processedBody = preg_replace(
            '/<a\s+(?:[^>]*?\s+)?href=(["\'])(.*?)\1[^>]*>(.*?)<\/a>/i',
            '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 20px 0;">
                <tr>
                    <td align="center">
                        <a href="$2" style="display: inline-block; background-color: #283C2A; color: #F1F2EF; padding: 5px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; font-family: Arial, sans-serif;">
                            $3
                        </a>
                    </td>
                </tr>
            </table>',
            $rawBody
        );

        return (new MailMessage)
            ->subject($subject)
            ->markdown('Emails.MailBase', [
                'body' => $processedBody,
                'footer' => $template->footer,
            ]);
    }
}