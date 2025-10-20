<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakımdayız - Spor Kulübü</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            text-align: center;
        }

        .maintenance-container {
            max-width: 600px;
            width: 100%;
            padding: 2rem;
        }

        .maintenance-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            color: #4ade80;
        }

        .maintenance-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #f8fafc;
        }

        .maintenance-message {
            font-size: 1.125rem;
            color: #cbd5e1;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .maintenance-timer {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .timer-title {
            font-size: 1rem;
            color: #94a3b8;
            margin-bottom: 0.75rem;
        }

        .countdown {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .time-unit {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .time-value {
            font-size: 2rem;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            min-width: 4rem;
        }

        .time-label {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-top: 0.5rem;
            text-transform: uppercase;
        }

        .contact-info {
            font-size: 0.875rem;
            color: #94a3b8;
            margin-top: 2rem;
        }

        .contact-info a {
            color: #60a5fa;
            text-decoration: none;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .maintenance-title {
                font-size: 1.5rem;
            }

            .maintenance-message {
                font-size: 1rem;
            }

            .time-value {
                font-size: 1.5rem;
                min-width: 3rem;
                padding: 0.25rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-icon">
            <i class="fas fa-tools"></i>
        </div>
        <h1 class="maintenance-title">Bakımdayız</h1>
        <p class="maintenance-message">
            <?php echo !empty($maintenance_message) ? htmlspecialchars($maintenance_message) : 'Sitemiz şu anda bakım çalışmaları nedeniyle geçici olarak hizmet dışıdır. Kısa süre sonra yeniden hizmetinizdeyiz.'; ?>
        </p>

        <?php if (!empty($maintenance_end_date)): ?>
        <div class="maintenance-timer">
            <div class="timer-title">Tahmini Dönüş:</div>
            <div class="countdown" id="countdown">
                <div class="time-unit">
                    <div class="time-value" id="days">00</div>
                    <div class="time-label">Gün</div>
                </div>
                <div class="time-unit">
                    <div class="time-value" id="hours">00</div>
                    <div class="time-label">Saat</div>
                </div>
                <div class="time-unit">
                    <div class="time-value" id="minutes">00</div>
                    <div class="time-label">Dakika</div>
                </div>
                <div class="time-unit">
                    <div class="time-value" id="seconds">00</div>
                    <div class="time-label">Saniye</div>
                </div>
            </div>
        </div>
        <script>
            // Set the date we're counting down to
            var countDownDate = new Date("<?php echo $maintenance_end_date; ?>").getTime();

            // Update the count down every 1 second
            var x = setInterval(function() {
                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result
                document.getElementById("days").innerHTML = days.toString().padStart(2, '0');
                document.getElementById("hours").innerHTML = hours.toString().padStart(2, '0');
                document.getElementById("minutes").innerHTML = minutes.toString().padStart(2, '0');
                document.getElementById("seconds").innerHTML = seconds.toString().padStart(2, '0');

                // If the count down is finished, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("countdown").innerHTML = "Tamamlanıyor...";
                }
            }, 1000);
        </script>
        <?php endif; ?>

        <div class="contact-info">
            <p>Sorularınız için bizimle iletişime geçebilirsiniz:</p>
            <p>
                <a href="mailto:<?php echo htmlspecialchars($contact_email ?? 'info@sporkulubu.com'); ?>">
                    <?php echo htmlspecialchars($contact_email ?? 'info@sporkulubu.com'); ?>
                </a>
            </p>
        </div>
    </div>
</body>
</html>