<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новая статья</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f5f5f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="padding: 40px 40px 20px; text-align: center;">
                            <div style="width: 48px; height: 48px; background-color: #385144; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                                <span style="color: #F8F5F2; font-size: 24px;">✍️</span>
                            </div>
                            <h1 style="margin: 0; font-size: 24px; font-weight: 600; color: #385144;">Новая статья</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 0 40px 40px;">
                            
                            <!-- Article Title -->
                            <div style="margin-bottom: 24px;">
                                <h2 style="margin: 0 0 8px; font-size: 20px; font-weight: 600; color: #1a1a1a; line-height: 1.4;">
                                    {{ $article->title }}
                                </h2>
                                <p style="margin: 0; font-size: 14px; color: #666;">
                                    {{ $article->user->name }} • {{ $article->created_at->format('d.m.Y H:i') }}
                                </p>
                            </div>
                            
                            <!-- Divider -->
                            <div style="height: 1px; background-color: #e5e5e5; margin: 24px 0;"></div>
                            
                            <!-- Article Excerpt -->
                            <div style="margin-bottom: 32px;">
                                <p style="margin: 0; font-size: 15px; color: #4a4a4a; line-height: 1.6;">
                                    {{ Str::limit(strip_tags($article->content), 180) }}
                                </p>
                            </div>
                            
                            <!-- Button -->
                            <div style="text-align: center;">
                                <a href="{{ url('/articles/' . $article->slug) }}" 
                                   style="display: inline-block; padding: 12px 32px; background-color: #385144; color: #ffffff; text-decoration: none; border-radius: 6px; font-size: 15px; font-weight: 500;">
                                    Открыть статью
                                </a>
                            </div>
                            
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 24px 40px; background-color: #fafafa; border-top: 1px solid #e5e5e5;">
                            <p style="margin: 0; font-size: 13px; color: #999; text-align: center; line-height: 1.5;">
                                Это автоматическое уведомление из {{ config('app.name') }}<br>
                                Вы получили это письмо как модератор блога
                            </p>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
