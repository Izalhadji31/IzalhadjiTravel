<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('errors.maintenance_title') }} - ASR GO</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .maintenance-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            padding: 60px 40px;
            text-align: center;
        }

        .maintenance-icon {
            font-size: 80px;
            margin-bottom: 30px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        h1 {
            color: #1a202c;
            font-size: 32px;
            margin-bottom: 15px;
        }

        .subtitle {
            color: #718096;
            font-size: 18px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .maintenance-info {
            background: #edf2f7;
            border-left: 4px solid #667eea;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
            text-align: left;
        }

        .maintenance-info h3 {
            color: #2d3748;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .maintenance-info p {
            color: #4a5568;
            font-size: 14px;
            line-height: 1.6;
        }

        .maintenance-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .detail-box {
            background: #f7fafc;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e2e8f0;
        }

        .detail-box .label {
            color: #718096;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .detail-box .value {
            color: #2d3748;
            font-size: 16px;
            font-weight: 600;
        }

        .status-badge {
            display: inline-block;
            background: #fed7d7;
            color: #c53030;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .contact-section {
            background: #edf2f7;
            border-radius: 12px;
            padding: 20px;
            margin: 30px 0;
        }

        .contact-section h3 {
            color: #2d3748;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .contact-link {
            display: inline-block;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            padding: 8px 0;
            border-bottom: 2px solid transparent;
            transition: border-color 0.3s;
        }

        .contact-link:hover {
            border-bottom-color: #667eea;
        }

        .contact-link + .contact-link {
            margin-left: 20px;
        }

        .footer-text {
            color: #a0aec0;
            font-size: 13px;
            margin-top: 30px;
        }

        @media (max-width: 600px) {
            .maintenance-container {
                padding: 40px 20px;
            }

            h1 {
                font-size: 24px;
            }

            .maintenance-icon {
                font-size: 60px;
            }

            .contact-link + .contact-link {
                display: block;
                margin-left: 0;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-icon">🔧</div>

        <div class="status-badge">
            {{ __('errors.maintenance_status') }}
        </div>

        <h1>{{ __('errors.maintenance_heading') }}</h1>
        <p class="subtitle">
            {{ __('errors.maintenance_message') }}
        </p>

        <div class="maintenance-info">
            <h3>{{ __('errors.maintenance_info_title') }}</h3>
            <p>
                {{ __('errors.maintenance_info') }}
            </p>
        </div>

        <div class="maintenance-details">
            <div class="detail-box">
                <div class="label">{{ __('errors.maintenance_system_status') }}</div>
                <div class="value">{{ __('errors.maintenance_in_progress') }}</div>
            </div>
            <div class="detail-box">
                <div class="label">{{ __('errors.maintenance_est_time') }}</div>
                <div class="value">{{ __('errors.maintenance_est_value') }}</div>
            </div>
            <div class="detail-box">
                <div class="label">{{ __('errors.maintenance_last_update') }}</div>
                <div class="value">{{ __('errors.maintenance_today') }}</div>
            </div>
        </div>

        <div class="contact-section">
            <h3>{{ __('errors.maintenance_help') }}</h3>
            <a href="https://wa.me/6283156408078?text=Halo%20ASR%20GO" target="_blank" class="contact-link">
                {{ __('errors.maintenance_wa') }}
            </a>
            <a href="mailto:info@asrgo.id" class="contact-link">
                {{ __('errors.maintenance_email') }}
            </a>
        </div>

        <p class="footer-text">
            {{ __('errors.maintenance_footer') }}
        </p>
    </div>
</body>
</html>
