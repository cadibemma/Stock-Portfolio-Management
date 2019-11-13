# Stock-Portfolio-Management

An Investment and Trading Platform where:

1) Users should be able to create / view / modify / delete their portfolios. Users can add/remove cash (always USD) to/from the portfolio, this will be the first thing a user does before buying stock. All transactions (cash, stock) should be dated and time-stamped.

1A) Users may create multiple portfolios and each portfolio should be reported and analyzed separately.

2) Users can buy and sell stocks traded on the US exchanges (NASDAQ, NYSE) and India (BSE/NSE) and Singapore (SGX.) When a stock is bought for the first time the buy price should automatically be the adjusted close price on 9/2/2019. Subsequent buy and sell transactions should automatically happen at the current market price or previous day’s close price. You may assume that users will buy stocks from (only) the Dow-30 (US), Nifty-Fifty (BSE) or STI (SGX).

3) The portfolio should be always marked to market, that is, when it is ‘viewed’ it should show the live price (if market is open) or previous day’s closing price (if market is closed) at the applicable foreign currency spot rates (live or previous day’s close). Users should be able to export their portfolio to a CSV file with all the relevant information (ticker; name; cost basis i.e. buy price, date, currency; current price; gain/loss and overall portfolio net-asset value).
