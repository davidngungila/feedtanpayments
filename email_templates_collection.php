<?php

/**
 * FeedTan CMG Email Templates Collection
 * Professional email templates using the provided format
 */

// Template 1: Welcome Email for New Members
$welcomeTemplate = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to FeedTan CMG - {memberName}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { margin: 0; padding: 0; background-color: #f0f4f8; font-family: 'Poppins', sans-serif; color: #333; line-height: 1.6; }
        .email-container { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08); border: 1px solid #e2e8f0; }
        .header { background: linear-gradient(135deg, #006400, #4CAF50); padding: 30px 25px; text-align: center; color: white; }
        .header .title { font-size: 26px; font-weight: 700; margin-bottom: 5px; }
        .header .sub-title { font-size: 14px; opacity: 0.9; }
        .content { padding: 30px 25px; }
        .greeting { font-size: 18px; font-weight: 600; color: #2d3748; margin-bottom: 15px; }
        
        .welcome-card { background: linear-gradient(135deg, #e8f5e8, #f0f8f0); border: 1px solid #c8e6c9; border-radius: 10px; padding: 25px; margin-bottom: 25px; text-align: center; }
        .welcome-icon { font-size: 48px; margin-bottom: 15px; }
        .welcome-card h3 { color: #2e7d32; margin-bottom: 10px; }
        
        .card { background-color: #f7fafc; border: 1px solid #edf2f7; border-radius: 8px; padding: 20px; margin-bottom: 25px; }
        .card-header { display: flex; align-items: center; margin-bottom: 15px; }
        .card-header .icon { font-size: 24px; margin-right: 12px; color: #4CAF50; }
        .card-header h4 { margin: 0; font-size: 16px; font-weight: 600; color: #2d3748; }

        .button-container { text-align: center; margin: 30px 0; }
        .cta-button { display: inline-block; padding: 12px 25px; background-color: #438a5e; color: white !important; font-weight: 600; border-radius: 6px; text-decoration: none; transition: all 0.3s ease; }
        .cta-button:hover { background-color: #2e7d32; transform: translateY(-2px); }
        
        .benefits-section { background-color: #fff8e1; border-left: 5px solid #FFC107; padding: 25px; border-radius: 8px; margin: 25px 0; }
        .benefits-section h4 { margin-top: 0; font-size: 18px; display: flex; align-items: center; color: #c09e4f; font-weight: 600; }
        .benefits-section .icon { font-size: 24px; margin-right: 10px; color: #c09e4f; }

        .signature { margin-top: 40px; font-size: 14px; color: #4a5568; }
        .footer { background: linear-gradient(135deg, #006400, #4CAF50); color: white; text-align: center; padding: 15px; font-size: 12px; letter-spacing: 0.5px; opacity: 0.8; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="title">Karibu FeedTan Community Microfinance Group</div>
            <div class="sub-title">P.O.Box 7744, Ushirika Sokoine Road, Moshi, Kilimanjaro, Tanzania</div>
        </div>
        <div class="content">
            <p class="greeting">Karibu {memberName},</p>
            <p style="font-size: 14px; color: #4a5568;">Tunatumai ujumbe huu unakufikia ukiwa na afya njema. Tunafurahi kukukaribisha katika familia ya FeedTan CMG!</p>

            <div class="welcome-card">
                <div class="welcome-icon">🎉</div>
                <h3>Hongera kwa Kujiunga!</h3>
                <p style="font-size: 14px; color: #4a5568;">Umeanza safari ya kujenga mustakabali wa kifedha pamoja na sisi.</p>
                <p style="font-size: 14px; color: #4a5568;"><strong>Namba Chanzo Chako:</strong> {memberNumber}</p>
                <p style="font-size: 14px; color: #4a5568;"><strong>Tarehe ya Kujiunga:</strong> {joinDate}</p>
            </div>

            <div class="card">
                <div class="card-header">
                    <span class="icon">📋</span>
                    <h4>Viendelezi Vyako</h4>
                </div>
                <p style="font-size: 14px; color: #4a5568;">Akaunti yako imeandaliwa na inaendelea zifuatazo:</p>
                <ul style="font-size: 14px; color: #4a5568; margin-left: 20px;">
                    <li>Akaunti ya Akiba yenye namba {savingsAccountNumber}</li>
                    <li>Akaunti ya Mikopo yenye uwezo wa {loanLimit}</li>
                    <li>Mfumo wa simu ya mkononi kwa ajili ya huduma</li>
                    <li>Ripoti ya mwezani kwa taarifa zako</li>
                </ul>
            </div>

            <div class="benefits-section">
                <h4><span class="icon">💎</span>Faida za Kuwa Mwanachama</h4>
                <p style="font-size: 14px; color: #4a5568;">Kama mwanachama wa FeedTan CMG, unapata:</p>
                <ul style="font-size: 14px; color: #4a5568; margin-left: 20px;">
                    <li>Mikopo nafuu na yenye masharti chanya</li>
                    <li>Mafunzo ya ujasiriamali na uendeshaji biashara</li>
                    <li>Ushauri wa kifedha wa bure</li>
                    <li>Fursa za kuwekeza kwenye miradi ya kijamii</li>
                </ul>
            </div>

            <div class="button-container">
                <a href="{portalLink}" class="cta-button" target="_blank">Ingia kwenye Portal Yako</a>
            </div>
            
            <p style="font-size: 14px; color: #4a5568;">Tafadhali wasiliana nasi ikiwa una swali lolote au unahitaji msaada.</p>

            <div class="signature">
                <p>Asante kwa kuamini sisi,<br><strong>Timu ya FeedTan CMG</strong></p>
                <p style="font-weight: 600; color: #006400;">Pamoja Tuweze Kufika! 🚀</p>
            </div>
        </div>
        <div class="footer">
            FeedTan CMG Welcome System V1.1.0.2026
        </div>
    </div>
</body>
</html>
HTML;

// Template 2: Loan Approval Notification
$loanApprovalTemplate = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Approval - FeedTan CMG</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { margin: 0; padding: 0; background-color: #f0f4f8; font-family: 'Poppins', sans-serif; color: #333; line-height: 1.6; }
        .email-container { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08); border: 1px solid #e2e8f0; }
        .header { background: linear-gradient(135deg, #2196F3, #4CAF50); padding: 30px 25px; text-align: center; color: white; }
        .header .title { font-size: 26px; font-weight: 700; margin-bottom: 5px; }
        .header .sub-title { font-size: 14px; opacity: 0.9; }
        .content { padding: 30px 25px; }
        .greeting { font-size: 18px; font-weight: 600; color: #2d3748; margin-bottom: 15px; }
        
        .approval-card { background: linear-gradient(135deg, #e3f2fd, #e8f5e8); border: 1px solid #90caf9; border-radius: 10px; padding: 25px; margin-bottom: 25px; text-align: center; }
        .approval-icon { font-size: 48px; margin-bottom: 15px; }
        .approval-card h3 { color: #1976d2; margin-bottom: 10px; }
        
        .card { background-color: #f7fafc; border: 1px solid #edf2f7; border-radius: 8px; padding: 20px; margin-bottom: 25px; }
        .card-header { display: flex; align-items: center; margin-bottom: 15px; }
        .card-header .icon { font-size: 24px; margin-right: 12px; color: #4CAF50; }
        .card-header h4 { margin: 0; font-size: 16px; font-weight: 600; color: #2d3748; }

        .loan-details { background-color: #f8f9fa; border-left: 4px solid #28a745; padding: 20px; margin: 20px 0; border-radius: 8px; }
        .loan-details h4 { color: #28a745; margin-top: 0; }
        
        .button-container { text-align: center; margin: 30px 0; }
        .accept-button { display: inline-block; padding: 12px 25px; background-color: #28a745; color: white !important; font-weight: 600; border-radius: 6px; text-decoration: none; transition: all 0.3s ease; margin: 0 10px; }
        .accept-button:hover { background-color: #218838; transform: translateY(-2px); }
        
        .next-steps { background-color: #fff3cd; border-left: 5px solid #ffc107; padding: 25px; border-radius: 8px; margin: 25px 0; }
        .next-steps h4 { margin-top: 0; font-size: 18px; display: flex; align-items: center; color: #856404; font-weight: 600; }
        .next-steps .icon { font-size: 24px; margin-right: 10px; color: #ffc107; }

        .signature { margin-top: 40px; font-size: 14px; color: #4a5568; }
        .footer { background: linear-gradient(135deg, #2196F3, #4CAF50); color: white; text-align: center; padding: 15px; font-size: 12px; letter-spacing: 0.5px; opacity: 0.8; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="title">Mkopo Wako Umekubaliwa! 🎉</div>
            <div class="sub-title">FeedTan Community Microfinance Group</div>
        </div>
        <div class="content">
            <p class="greeting">Habari {memberName},</p>
            <p style="font-size: 14px; color: #4a5568;">Tunafurahi kukuarifu kuwa maombi yako ya mkopo yamekubaliwa!</p>

            <div class="approval-card">
                <div class="approval-icon">✅</div>
                <h3>Mkopo Wako Umekubaliwa!</h3>
                <p style="font-size: 14px; color: #4a5568;">Maombi yako ya mkopo ya TZS {loanAmount} yamekubaliwa.</p>
                <p style="font-size: 14px; color: #4a5568;"><strong>Namba ya Mkopo:</strong> {loanNumber}</p>
                <p style="font-size: 14px; color: #4a5568;"><strong>Tarehe ya Idhini:</strong> {approvalDate}</p>
            </div>

            <div class="loan-details">
                <h4>💰 Maelezo ya Mkopo</h4>
                <table style="width: 100%; font-size: 14px; color: #4a5568;">
                    <tr><td><strong>Kiasi cha Mkopo:</strong></td><td>TZS {loanAmount}</td></tr>
                    <tr><td><strong>Kiasi la Riba:</strong></td><td>{interestRate}% kwa mwaka</td></tr>
                    <tr><td><strong>Muda wa Kulipa:</strong></td><td>{repaymentPeriod} miezi</td></tr>
                    <tr><td><strong>Mweza wa Kila Mwezi:</strong></td><td>TZS {monthlyPayment}</td></tr>
                    <tr><td><strong>Tarehe ya Kuanza Kulipa:</strong></td><td>{firstPaymentDate}</td></tr>
                    <tr><td><strong>Tarehe ya Malipo ya Mwisho:</strong></td><td>{lastPaymentDate}</td></tr>
                </table>
            </div>

            <div class="card">
                <div class="card-header">
                    <span class="icon">📄</span>
                    <h4>Vipengele vya Mkopo</h4>
                </div>
                <ul style="font-size: 14px; color: #4a5568; margin-left: 20px;">
                    <li>Riba ya asilimia {interestRate}% kwa mwaka</li>
                    <li>Muda wa malipo: {repaymentPeriod} miezi</li>
                    <li>Malipo ya kila mwezi: TZS {monthlyPayment}</li>
                    <li>Hakza ada za usajili au usindikishaji</li>
                    <li>Uwezo wa kupunguza mkopo mapema bila adhabu</li>
                </ul>
            </div>

            <div class="next-steps">
                <h4><span class="icon">📋</span>Vyendelezi Vifuatavyo</h4>
                <ol style="font-size: 14px; color: #4a5568; margin-left: 20px;">
                    <li>Pitia na kukubali masharti ya mkopo</li>
                    <li>Pokea fedha kwenye akaunti yako ya benki</li>
                    <li>Anza kulipa awamu ya kwanza tarehe {firstPaymentDate}</li>
                    <li>Pata ripoti ya malipo kila mwezi</li>
                </ol>
            </div>

            <div class="button-container">
                <a href="{acceptLink}" class="accept-button" target="_blank">Kubali Masharti ya Mkopo</a>
                <a href="{detailsLink}" class="accept-button" target="_blank">Maelezo Zaidi</a>
            </div>
            
            <p style="font-size: 14px; color: #4a5568;">Tafadhali wasiliana nasi ikiwa una swali lolote kuhusu mkopo wako.</p>

            <div class="signature">
                <p>Polepole na nidhamu,<br><strong>Idara ya Mikopo</strong></p>
                <p style="font-weight: 600; color: #2196F3;">Tunakusaidia Kufikia Malengo Yako! 💪</p>
            </div>
        </div>
        <div class="footer">
            FeedTan CMG Loan System V1.1.0.2026
        </div>
    </div>
</body>
</html>
HTML;

// Template 3: Loan Repayment Reminder
$repaymentReminderTemplate = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Repayment Reminder - FeedTan CMG</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { margin: 0; padding: 0; background-color: #f0f4f8; font-family: 'Poppins', sans-serif; color: #333; line-height: 1.6; }
        .email-container { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08); border: 1px solid #e2e8f0; }
        .header { background: linear-gradient(135deg, #ff6b6b, #ffa500); padding: 30px 25px; text-align: center; color: white; }
        .header .title { font-size: 26px; font-weight: 700; margin-bottom: 5px; }
        .header .sub-title { font-size: 14px; opacity: 0.9; }
        .content { padding: 30px 25px; }
        .greeting { font-size: 18px; font-weight: 600; color: #2d3748; margin-bottom: 15px; }
        
        .reminder-card { background: linear-gradient(135deg, #fff5f5, #fff8e1); border: 1px solid #ffcdd2; border-radius: 10px; padding: 25px; margin-bottom: 25px; text-align: center; }
        .reminder-icon { font-size: 48px; margin-bottom: 15px; }
        .reminder-card h3 { color: #d32f2f; margin-bottom: 10px; }
        
        .payment-info { background-color: #f8f9fa; border-left: 4px solid #ff9800; padding: 20px; margin: 20px 0; border-radius: 8px; }
        .payment-info h4 { color: #ff9800; margin-top: 0; }
        
        .urgent-notice { background-color: #ffebee; border-left: 5px solid #f44336; padding: 25px; border-radius: 8px; margin: 25px 0; }
        .urgent-notice h4 { margin-top: 0; font-size: 18px; display: flex; align-items: center; color: #c62828; font-weight: 600; }
        .urgent-notice .icon { font-size: 24px; margin-right: 10px; color: #f44336; }

        .payment-methods { background-color: #e8f5e8; border: 1px solid #a5d6a7; border-radius: 8px; padding: 20px; margin: 20px 0; }
        .payment-methods h4 { color: #2e7d32; margin-top: 0; }

        .button-container { text-align: center; margin: 30px 0; }
        .pay-button { display: inline-block; padding: 12px 25px; background-color: #ff6b6b; color: white !important; font-weight: 600; border-radius: 6px; text-decoration: none; transition: all 0.3s ease; }
        .pay-button:hover { background-color: #d32f2f; transform: translateY(-2px); }

        .signature { margin-top: 40px; font-size: 14px; color: #4a5568; }
        .footer { background: linear-gradient(135deg, #ff6b6b, #ffa500); color: white; text-align: center; padding: 15px; font-size: 12px; letter-spacing: 0.5px; opacity: 0.8; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="title">Kumbukumbu la Malizo ya Mkopo</div>
            <div class="sub-title">FeedTan Community Microfinance Group</div>
        </div>
        <div class="content">
            <p class="greeting">Habari {memberName},</p>
            <p style="font-size: 14px; color: #4a5568;">Hii ni kumbukumbu la malizo ya mkopo wako kwa mwezi {month} {year}.</p>

            <div class="reminder-card">
                <div class="reminder-icon">⏰</div>
                <h3>Malizo ya Mkopo Yako Yanakaribia!</h3>
                <p style="font-size: 14px; color: #4a5568;">Tarehe ya malizo: {dueDate}</p>
                <p style="font-size: 14px; color: #4a5568;">Siku zilizosalia: {daysRemaining}</p>
                <p style="font-size: 14px; color: #4a5568;"><strong>Kiasi cha Malizo:</strong> TZS {paymentAmount}</p>
            </div>

            <div class="payment-info">
                <h4>💳 Maelezo ya Malizo</h4>
                <table style="width: 100%; font-size: 14px; color: #4a5568;">
                    <tr><td><strong>Namba ya Mkopo:</strong></td><td>{loanNumber}</td></tr>
                    <tr><td><strong>Kiasi cha Malizo:</strong></td><td>TZS {paymentAmount}</td></tr>
                    <tr><td><strong>Tarehe ya Malizo:</strong></td><td>{dueDate}</td></tr>
                    <tr><td><strong>Aina ya Malizo:</strong></td><td>{paymentType}</td></tr>
                    <tr><td><strong>Salio la Mkopo:</strong></td><td>TZS {outstandingBalance}</td></tr>
                </table>
            </div>

            <div class="payment-methods">
                <h4>💰 Njia za Malizo</h4>
                <ul style="font-size: 14px; color: #4a5568; margin-left: 20px;">
                    <li>Malizo kwenye akaunti yao benki: {bankAccountNumber}</li>
                    <li>Malizo kupitia simu ya mkononi: {mobileNumber}</li>
                    <li>Malizo moja kwa moja ofisini</li>
                    <li>Malizo kupitia Tigo Pesa, M-Pesa, au Airtel Money</li>
                </ul>
            </div>

            <div class="urgent-notice">
                <h4><span class="icon">⚠️</span>Tahadhari Muhimu</h4>
                <p style="font-size: 14px; color: #4a5568;">Malizo ya wakati husababisha adhabu ya TZS {lateFee}</p>
                <p style="font-size: 14px; color: #4a5568;">Adhabu ya kuchelewa itaanza kutumika tarehe {lateFeeDate}</p>
                <p style="font-size: 14px; color: #4a5568;">Tafadhali fanya malizo kabla ya tarehe ya mwisho.</p>
            </div>

            <div class="button-container">
                <a href="{paymentLink}" class="pay-button" target="_blank">Fanya Malizo Sasa</a>
            </div>
            
            <p style="font-size: 14px; color: #4a5568;">Ikiwa umeshafanya malizo, tafadhali puuza ujumbe huu.</p>
            <p style="font-size: 14px; color: #4a5568;">Kwa msaada zaidi, wasiliana nasi kwenye namba {supportNumber}.</p>

            <div class="signature">
                <p>Asante kwa ushirikiano wako,<br><strong>Idara ya Ukusanyaji</strong></p>
                <p style="font-weight: 600; color: #ff6b6b;">Tunathamini Malizo Yako ya Wakati! ⏰</p>
            </div>
        </div>
        <div class="footer">
            FeedTan CMG Payment System V1.1.0.2026
        </div>
    </div>
</body>
</html>
HTML;

// Template 4: Account Balance Notification
$balanceNotificationTemplate = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Balance Update - FeedTan CMG</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { margin: 0; padding: 0; background-color: #f0f4f8; font-family: 'Poppins', sans-serif; color: #333; line-height: 1.6; }
        .email-container { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08); border: 1px solid #e2e8f0; }
        .header { background: linear-gradient(135deg, #6a11cb, #2575fc); padding: 30px 25px; text-align: center; color: white; }
        .header .title { font-size: 26px; font-weight: 700; margin-bottom: 5px; }
        .header .sub-title { font-size: 14px; opacity: 0.9; }
        .content { padding: 30px 25px; }
        .greeting { font-size: 18px; font-weight: 600; color: #2d3748; margin-bottom: 15px; }
        
        .balance-card { background: linear-gradient(135deg, #f3e5f5, #e8f5e8); border: 1px solid #ce93d8; border-radius: 10px; padding: 25px; margin-bottom: 25px; text-align: center; }
        .balance-icon { font-size: 48px; margin-bottom: 15px; }
        .balance-card h3 { color: #6a1b9a; margin-bottom: 10px; }
        .balance-amount { font-size: 32px; font-weight: 700; color: #2575fc; margin: 15px 0; }
        
        .account-summary { background-color: #f7fafc; border: 1px solid #edf2f7; border-radius: 8px; padding: 20px; margin-bottom: 25px; }
        .account-summary h4 { color: #2d3748; margin-top: 0; }
        
        .transaction-list { background-color: #f8f9fa; border-radius: 8px; padding: 20px; margin: 20px 0; }
        .transaction-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e9ecef; }
        .transaction-item:last-child { border-bottom: none; }
        
        .savings-tips { background-color: #e3f2fd; border-left: 5px solid #2196F3; padding: 25px; border-radius: 8px; margin: 25px 0; }
        .savings-tips h4 { margin-top: 0; font-size: 18px; display: flex; align-items: center; color: #1976d2; font-weight: 600; }
        .savings-tips .icon { font-size: 24px; margin-right: 10px; color: #2196F3; }

        .button-container { text-align: center; margin: 30px 0; }
        .view-button { display: inline-block; padding: 12px 25px; background-color: #6a11cb; color: white !important; font-weight: 600; border-radius: 6px; text-decoration: none; transition: all 0.3s ease; }
        .view-button:hover { background-color: #2575fc; transform: translateY(-2px); }

        .signature { margin-top: 40px; font-size: 14px; color: #4a5568; }
        .footer { background: linear-gradient(135deg, #6a11cb, #2575fc); color: white; text-align: center; padding: 15px; font-size: 12px; letter-spacing: 0.5px; opacity: 0.8; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="title">Taarifa ya Salio la Akaunti</div>
            <div class="sub-title">FeedTan Community Microfinance Group</div>
        </div>
        <div class="content">
            <p class="greeting">Habari {memberName},</p>
            <p style="font-size: 14px; color: #4a5568;">Hii ni taarifa ya salio la akaunti yako kwa tarehe {statementDate}.</p>

            <div class="balance-card">
                <div class="balance-icon">💰</div>
                <h3>Salio la Akiba Yako</h3>
                <div class="balance-amount">TZS {currentBalance}</div>
                <p style="font-size: 14px; color: #4a5568;">Mabadiliko kutoka mwezi uliopita: TZS {monthlyChange}</p>
                <p style="font-size: 14px; color: #4a5568;"><strong>Jumla ya Akiba:</strong> TZS {totalSavings}</p>
            </div>

            <div class="account-summary">
                <h4>📊 Muhtasari wa Akaunti</h4>
                <table style="width: 100%; font-size: 14px; color: #4a5568;">
                    <tr><td><strong>Namba ya Akaunti:</strong></td><td>{accountNumber}</td></tr>
                    <tr><td><strong>Aina ya Akaunti:</strong></td><td>{accountType}</td></tr>
                    <tr><td><strong>Salio la Sasa:</strong></td><td>TZS {currentBalance}</td></tr>
                    <tr><td><strong>Akiba ya Mwezi Huu:</strong></td><td>TZS {monthlySavings}</td></tr>
                    <tr><td><strong>Riba Imepokelewa:</strong></td><td>TZS {interestEarned}</td></tr>
                    <tr><td><strong>Tarehe ya Mwisho wa Ripoti:</strong></td><td>{statementDate}</td></tr>
                </table>
            </div>

            <div class="transaction-list">
                <h4 style="color: #2d3748; margin-bottom: 15px;">Muamala wa Hivi Karibuni</h4>
                {recentTransactions}
            </div>

            <div class="savings-tips">
                <h4><span class="icon">💡</span>Vidokezo vya Kuongeza Akiba</h4>
                <ul style="font-size: 14px; color: #4a5568; margin-left: 20px;">
                    <li>Weka akiba ya kila mwezi kabla ya matumizi</li>
                    <li>Lenga gharama zisizo za lazima</li>
                    <li>Weka malengo maalum ya akiba</li>
                    <li>Tumia fursa za kuwekeza zilizopo</li>
                </ul>
            </div>

            <div class="button-container">
                <a href="{portalLink}" class="view-button" target="_blank">Ona Maelezo Zaidi</a>
            </div>
            
            <p style="font-size: 14px; color: #4a5568;">Kwa maelezo zaidi kuhusu akaunti yako, wasiliana nasi.</p>

            <div class="signature">
                <p>Kwa huduma zaidi,<br><strong>Idara ya Akaunti</strong></p>
                <p style="font-weight: 600; color: #6a11cb;">Akiba Yako ni Mustakabali Wako! 🏦</p>
            </div>
        </div>
        <div class="footer">
            FeedTan CMG Account System V1.1.0.2026
        </div>
    </div>
</body>
</html>
HTML;

// Template 5: Meeting Invitation
$meetingInvitationTemplate = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Invitation - FeedTan CMG</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { margin: 0; padding: 0; background-color: #f0f4f8; font-family: 'Poppins', sans-serif; color: #333; line-height: 1.6; }
        .email-container { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08); border: 1px solid #e2e8f0; }
        .header { background: linear-gradient(135deg, #8e44ad, #3498db); padding: 30px 25px; text-align: center; color: white; }
        .header .title { font-size: 26px; font-weight: 700; margin-bottom: 5px; }
        .header .sub-title { font-size: 14px; opacity: 0.9; }
        .content { padding: 30px 25px; }
        .greeting { font-size: 18px; font-weight: 600; color: #2d3748; margin-bottom: 15px; }
        
        .meeting-card { background: linear-gradient(135deg, #f3e5f5, #e3f2fd); border: 1px solid #ba68c8; border-radius: 10px; padding: 25px; margin-bottom: 25px; text-align: center; }
        .meeting-icon { font-size: 48px; margin-bottom: 15px; }
        .meeting-card h3 { color: #7b1fa2; margin-bottom: 10px; }
        
        .meeting-details { background-color: #f8f9fa; border-left: 4px solid #8e44ad; padding: 20px; margin: 20px 0; border-radius: 8px; }
        .meeting-details h4 { color: #8e44ad; margin-top: 0; }
        
        .agenda-section { background-color: #fff8e1; border: 1px solid #ffb74d; border-radius: 8px; padding: 20px; margin: 20px 0; }
        .agenda-section h4 { color: #f57c00; margin-top: 0; }
        
        .location-info { background-color: #e8f5e8; border-left: 5px solid #4caf50; padding: 25px; border-radius: 8px; margin: 25px 0; }
        .location-info h4 { margin-top: 0; font-size: 18px; display: flex; align-items: center; color: #2e7d32; font-weight: 600; }
        .location-info .icon { font-size: 24px; margin-right: 10px; color: #4caf50; }

        .button-container { text-align: center; margin: 30px 0; }
        .rsvp-button { display: inline-block; padding: 12px 25px; background-color: #8e44ad; color: white !important; font-weight: 600; border-radius: 6px; text-decoration: none; transition: all 0.3s ease; margin: 0 10px; }
        .rsvp-button:hover { background-color: #7b1fa2; transform: translateY(-2px); }
        .calendar-button { display: inline-block; padding: 12px 25px; background-color: #3498db; color: white !important; font-weight: 600; border-radius: 6px; text-decoration: none; transition: all 0.3s ease; margin: 0 10px; }
        .calendar-button:hover { background-color: #2980b9; transform: translateY(-2px); }

        .signature { margin-top: 40px; font-size: 14px; color: #4a5568; }
        .footer { background: linear-gradient(135deg, #8e44ad, #3498db); color: white; text-align: center; padding: 15px; font-size: 12px; letter-spacing: 0.5px; opacity: 0.8; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="title">Mwaliko wa Mkutano</div>
            <div class="sub-title">FeedTan Community Microfinance Group</div>
        </div>
        <div class="content">
            <p class="greeting">Habari {memberName},</p>
            <p style="font-size: 14px; color: #4a5568;">Tunakualika kwenye mkutano muhimu wa {meetingType}.</p>

            <div class="meeting-card">
                <div class="meeting-icon">📅</div>
                <h3>Mkutano wa {meetingType}</h3>
                <p style="font-size: 14px; color: #4a5568;"><strong>Tarehe:</strong> {meetingDate}</p>
                <p style="font-size: 14px; color: #4a5568;"><strong>Muda:</strong> {meetingTime}</p>
                <p style="font-size: 14px; color: #4a5568;"><strong>Muda wa Kudumu:</strong> {duration}</p>
            </div>

            <div class="meeting-details">
                <h4>📋 Maelezo ya Mkutano</h4>
                <table style="width: 100%; font-size: 14px; color: #4a5568;">
                    <tr><td><strong>Aina ya Mkutano:</strong></td><td>{meetingType}</td></tr>
                    <tr><td><strong>Tarehe:</strong></td><td>{meetingDate}</td></tr>
                    <tr><td><strong>Muda:</strong></td><td>{meetingTime}</td></tr>
                    <tr><td><strong>Muda wa Kudumu:</strong></td><td>{duration}</td></tr>
                    <tr><td><strong>Mgenyi Mkutano:</strong></td><td>{organizer}</td></tr>
                    <tr><td><strong>Namba ya Watu:</strong></td><td>{expectedAttendees}</td></tr>
                </table>
            </div>

            <div class="location-info">
                <h4><span class="icon">📍</span>Eneo la Mkutano</h4>
                <p style="font-size: 14px; color: #4a5568;"><strong>Jengo:</strong> {buildingName}</p>
                <p style="font-size: 14px; color: #4a5568;"><strong>Chumba:</strong> {roomNumber}</p>
                <p style="font-size: 14px; color: #4a5568;"><strong>Anuani:</strong> {address}</p>
                <p style="font-size: 14px; color: #4a5568;"><strong>Maelezo Zaidi:</strong> {additionalDirections}</p>
            </div>

            <div class="agenda-section">
                <h4>📝 Ratiba ya Mkutano</h4>
                <ol style="font-size: 14px; color: #4a5568; margin-left: 20px;">
                    {agendaItems}
                </ol>
            </div>

            <div class="button-container">
                <a href="{rsvpLink}" class="rsvp-button" target="_blank">Thibitisha Ushiriki</a>
                <a href="{calendarLink}" class="calendar-button" target="_blank">Ongeza kwenye Kalenda</a>
            </div>
            
            <p style="font-size: 14px; color: #4a5568;">Tafadhali thibitisha ushiriki wako kabla ya tarehe {rsvpDeadline}.</p>
            <p style="font-size: 14px; color: #4a5568;">Ikiwa hauwezi kuhudhuria, tafadhali tuarifu mapema.</p>

            <div class="signature">
                <p>Tunakutegemea kuhudhuria,<br><strong>{organizer}</strong></p>
                <p style="font-weight: 600; color: #8e44ad;">Pamoja Tuweze Kufanikiwa! 🤝</p>
            </div>
        </div>
        <div class="footer">
            FeedTan CMG Meeting System V1.1.0.2026
        </div>
    </div>
</body>
</html>
HTML;

echo "=== FeedTan CMG Email Templates Collection ===\n\n";
echo "Created 5 professional email templates:\n\n";

echo "1. Welcome Email Template\n";
echo "   - For new members joining FeedTan CMG\n";
echo "   - Includes member details, benefits, and portal access\n\n";

echo "2. Loan Approval Notification\n";
echo "   - Notifies when loan applications are approved\n";
echo "   - Includes loan details, terms, and acceptance options\n\n";

echo "3. Loan Repayment Reminder\n";
echo "   - Reminds members about upcoming loan payments\n";
echo "   - Includes payment methods and late fee warnings\n\n";

echo "4. Account Balance Notification\n";
echo "   - Monthly account balance statements\n";
echo "   - Includes transaction history and savings tips\n\n";

echo "5. Meeting Invitation\n";
echo "   - Invites members to various meetings\n";
echo "   - Includes agenda, location, and RSVP options\n\n";

echo "=== Usage Instructions ===\n";
echo "Each template uses variables like {memberName}, {amount}, etc.\n";
echo "Replace these variables with actual data when sending emails.\n";
echo "All templates follow the same professional design and branding.\n\n";

echo "=== Template Features ===\n";
echo "- Professional design with FeedTan CMG branding\n";
echo "- Responsive layout for mobile and desktop\n";
echo "- Swahili content for local relevance\n";
echo "- Interactive elements and call-to-action buttons\n";
echo "- Consistent color scheme and typography\n\n";

echo "=== Implementation ===\n";
echo "These templates can be used in:\n";
echo "- Laravel email notifications\n";
echo "- Automated email campaigns\n";
echo "- Manual email sending from admin panel\n";
echo "- Customer communication systems\n\n";

echo "=== Templates Ready for Use ===\n";
echo "All 5 templates are now ready for integration into the FeedTan CMG system!\n";
