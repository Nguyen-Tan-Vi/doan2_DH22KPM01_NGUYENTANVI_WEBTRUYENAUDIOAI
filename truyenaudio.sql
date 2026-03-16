-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 16, 2026 lúc 01:35 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `truyenaudio`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chapter`
--

CREATE TABLE `chapter` (
  `id` int(10) UNSIGNED NOT NULL,
  `truyen_id` int(10) NOT NULL,
  `tieude` varchar(255) NOT NULL,
  `tomtat` mediumtext NOT NULL,
  `noidung` text NOT NULL,
  `so_chuong` int(11) DEFAULT 0,
  `kichhoat` int(11) NOT NULL,
  `slug_chapter` varchar(255) NOT NULL,
  `ngay_cap_nhat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chapter`
--

INSERT INTO `chapter` (`id`, `truyen_id`, `tieude`, `tomtat`, `noidung`, `so_chuong`, `kichhoat`, `slug_chapter`, `ngay_cap_nhat`) VALUES
(1, 1, 'Chap 1: Cuộc gặp gỡ định mệnh', '', 'Chíp chíp...\r\n\r\nMột ngày mới bắt đầu, Albus dụi đi cặp mắt đỏ ngầu của mình rồi tỉnh dậy khỏi chiếc giường bệnh.\r\n\r\nOáp~\r\n\r\nMột tiếng ngáp dài để khởi đầu một buổi sáng bận rộn được cất lên.\r\n\r\nNgay sau đó thì một cô người hầu với sắc da màu tím nhẹ và sáu con mắt giống với loài nhện xuất hiện cùng một chiếc xe đẩy với một chiếc mâm bạc đang che đi bữa sáng mà Albus có lẽ là đang mong chờ.\r\n\r\n\"Ngài dậy rồi à?\" (???)\r\n\r\nAlbus không trả lời mà chỉ gật đầu.\r\n\r\n\"Hôm nay ăn gì vậy Iris?\" (Albus)\r\n\r\n\"Nay ngài có thể ăn em...\" (Iris)\r\n\r\nIris vừa nói vừa đưa tay chạm nhẹ vào bờ vai, sáu con mắt đồng loạt chớp chớp đầy tình tứ.\r\n\r\n\"Vậy thì cút.\" (Albus)\r\n\r\nAlbus ngắt lời không chút nể nang. Iris phồng má, khuôn mặt tím nhẹ đỏ lựng lên như quả cà chua vì hậm hực.\r\n\r\nVới sáu con mắt của mình thì Iris dùng hai con mắt nhìn Albus đắm đuối, hai con nhìn Albus mong anh ấy thay đổi quyết định, hai con còn lại thì rưng rưng sắp khóc.\r\n\r\nNhưng thứ mà cô ấy nhận lại chỉ là sự lạnh lùng và lạnh nhạt của Albus mà thôi.\r\n\r\n\"Ngài thật quá đáng!\" (Iris)\r\n\r\nDù càu nhàu, cô vẫn chuyên nghiệp mở chiếc nắp bạc, để lộ bữa sáng đầy đặn với thịt xông khói, xúc xích và đậu nướng. Dưới gầm xe, một chai rượu không nhãn mác được lấy ra, làn hơi lạnh tỏa ra mờ ảo quanh chiếc ly thủy tinh tinh xảo.\r\n\r\n\"Vậy đồ ăn của cô ấy đâu?\" (Albus)\r\n\r\nCô ấy?\r\n\r\nĐúng rồi, đó là tôi Felisia, người đang nằm ở chiếc giường bên cạnh cái của Albus.\r\n\r\nTôi cố nhớ rõ những gì diễn ra hôm qua mà có thể khiến bản thân phải chịu cảnh đầy khó xử này đây.\r\n\r\n.\r\n\r\n.\r\n\r\n.\r\n\r\nTôi là Irena Caeles Scarlet. Với cái tên dài dằng dặc này, hẳn ai cũng đoán được tôi là một quý tộc. Là trưởng nữ của một Hầu tước phục vụ Hoàng gia, số phận của tôi vốn đã được định đoạt từ khi mới lọt lòng.\r\n\r\nLà một người con gái của một quý tộc thì sở hữu một hôn ước chính trị là điều khó tránh, vì nó là cách giúp củng cố quyền lực cho gia tộc Scarlet tốt nhất.\r\n\r\nNhưng đó chưa bao giờ là điều tôi khao khát.\r\n\r\nTôi có một ước mơ cháy bỏng là trở thành một thần tượng, đứng dưới ánh đèn sân khấu trước hàng triệu người hâm mộ, ca hát và nhảy múa cho đến khi đôi chân này kiệt sức mới thôi.\r\n\r\nVì lẽ đó, tôi đã dùng quyền lực của mình để âm thầm chuẩn bị một \"cuộc đời mới\". Giấy khai sinh giả, thân phận giả... Ngay khi vừa tròn tuổi trưởng thành, tôi lập tức đào tẩu khỏi gia tộc.\r\n\r\nVới cái tên mới là Felisia và tôi đã nhuộm tóc để che đi mái tóc đỏ độc quyền của gia tộc bằng mái tóc nâu đỏ tuy không phổ biến nhưng cũng không phải là quý tộc nào cũng sỡ hữu.\r\n\r\nTôi đặt chân đến Aethelgard, Thành phố Cộng hòa nơi loài người và quái vật chung sống. Trớ trêu thay, đời không như là mơ. Ba năm kể từ ngày bỏ trốn, thay vì đứng trên sân khấu rực rỡ, tôi lại đang phải kiếm sống bằng cách hát rong giữa những khu chợ tấp nập bụi bặm.\r\n\r\nTuy đồng tiền kiếm được chỉ đủ để tôi sống qua ngày tuy nhiên nó lại không hề khiến tôi chán nản. Bởi vì không ai đi trên con đường bằng phẳng suốt được, ai rồi cũng sẽ gặp những thử thách và khi vượt qua nó thì mới có quyền chạm được tới ước mơ của mình.\r\n\r\nCuộc sống của tôi có lẽ vẫn sẽ bình lặng như thế, nếu không vì một sai lầm khiến định mệnh rẽ sang một hướng mà đến chính tôi cũng chẳng rõ là phúc hay họa.\r\n\r\n.\r\n\r\n.\r\n\r\n.\r\n\r\nĐó là một buổi chiều thu, khi những tán cây trong công viên bắt đầu trút lá theo từng cơn gió se lạnh. Buổi hát rong thường nhật của tôi buộc phải kết thúc sớm khi những hạt mưa đầu mùa lác đác rơi xuống. Không mang theo ô, tôi chỉ biết nép mình dưới mái hiên của một cửa hàng gần đó.\r\n\r\nTôi lặng lẽ nhìn dòng người hối hả tìm chỗ trú, nhìn những chiếc xe lướt qua hất tung làn nước bẩn, và cả những lá vàng bị cuốn trôi xuống miệng cống tối tăm.\r\n\r\nCơn mưa đầu mùa chợt đến rồi chợt đi. Tôi rời khỏi chỗ nấp, lách qua những giọt nước còn đọng lại đang lăng tăng rơi xuống từ mái hiên. Tay ôm chặt chiếc hộp chứa đàn guitar, tôi định ghé qua chợ mua ít nhu yếu phẩm rồi về nhà. Tuy nhiên, con đường quen thuộc hôm nay lại đông đúc đến lạ thường.\r\n\r\nĐể kịp về nhà trước khi trời sập tối, tôi chỉ còn cách nuốt nước bọt, lấy hết can đảm bước chân vào lối tắt băng qua khu ổ chuột, nơi vốn dĩ không dành cho những người như tôi.\r\n\r\nTôi vừa đi vừa cẩn thận rà soát danh sách nhu yếu phẩm. Sau khi khóa túi xách, tôi thở phào một cái, nhưng ngay khoảnh khắc đó...\r\n\r\nGẦM!\r\n\r\nTôi đâm sầm vào một tấm lưng vững chãi như bàn thạch. Đó là một gã đàn ông lực lưỡng với hình xăm hổ trắng hung tợn. Xung quanh gã, những sinh vật lai và con người với đủ loại hình xăm thú dữ đang bao vây lấy tôi.\r\n\r\n\"Vết xăm đó... hỏng rồi! Là người của băng Bách Thú!\" (Felisia)\r\n\r\nTôi chạy bán mạng, lao thẳng vào một con hẻm theo lời chỉ dẫn của gã người chuột để rồi nhận ra mình đã rơi vào ngõ cụt. Một không gian tăm tối, nồng nặc mùi ẩm mốc và rêu xanh.\r\n\r\n\"Đưa hết tiền bạc đây, ngay lập tức!\" (Tên côn đồ)\r\n\r\n\"Không! Tôi chỉ vô tình đụng trúng thôi, tại sao tôi phải đưa đồ cho các người?\" (Felisia)\r\n\r\nCâu trả lời của tôi chỉ khiến chúng thêm điên tiết. Một cú đấm sấm sét giáng xuống, tôi vấp ngã vì vũng nước nên thoát chết trong gang tấc, nhưng bức tường phía sau đã vỡ nát thành từng mảnh. Chúng không để tôi kịp định thần, liền thô bạo ép sát tôi vào đống gạch đổ nát.\r\n\r\n\"Hự!!!\" (Felisia)\r\n\r\nLưỡi dao sắc lạnh của gã người chuột kề sát cổ tôi. Chúng không chỉ muốn tiền, chúng muốn \"phần lãi\" từ chính cơ thể tôi. Sự tuyệt vọng bóp nghẹt trái tim khi chiếc áo ngoài bị xé rách toạc.\r\n\r\nƯớc mơ của mình... phải kết thúc nhục nhã thế này sao? Vận mệnh thực sự không cho mình một lối thoát sao?\r\n\r\nTôi nhắm mắt, mặc cho dòng lệ nóng hổi lăn dài. Đúng lúc đó, một âm thanh khô khốc vang lên.\r\n\r\nCốc\r\n\r\nGiữa ánh sáng nhạt nhòa nơi đầu hẻm, một bóng người hiện ra. Chiếc áo choàng tím sẫm cùng khăn choàng đỏ tung bay trong gió. Anh ta cầm một chai rượu thủy tinh, giọng nói trầm thấp nhưng đầy uy lực.\r\n\r\n\"Các ngươi... đang làm gì vậy?\" (???)\r\n\r\n\"Làm ơn... cứu tôi với!\" (Felisia)\r\n\r\nSau lời hứa sẽ trao cho anh ta \"bất cứ thứ gì\" để đổi lấy mạng sống, tôi nhắm nghiền mắt lại theo lời anh ta dặn. \r\n\r\nNgay sau đó thì âm thanh cắt của gió và tiếng hét xé lòng vang lên trong bóng tối, nó như đánh thức nỗi sợ sâu trong lòng tôi, khiến tôi khó thở và chóng mặt.\r\n\r\nMọi thứ trở lại tĩnh lặng đến đáng sợ. Khi tôi mở mắt, những kẻ vừa rồi đã hóa thành bụi tro. Người đàn ông bí ẩn ngồi xuống trước mặt tôi, gãi đầu bối rối khi thấy tôi bật khóc nức nở. Sau khi anh búng tay xóa sổ đám tàn quân định đánh lén, tôi bất ngờ nhào tới ôm chầm lấy anh. Nhưng khi tôi buông tay, mảnh áo rách còn lại cũng rơi xuống.\r\n\r\nCả hai đứng hình, mặt đỏ bừng. Anh lúng túng quay đi, cởi chiếc áo khoác để nhường cho tôi. Đó cũng là lúc tôi nhìn thấy cơ thể anh qua lớp áo trong. những vết sẹo chằng chịt, những vết khâu cũ kỹ và cả những mảnh xương dường như được nối lại bằng dây thép. Một cơ thể của sự chịu đựng và đau đớn.\r\n\r\n\"Mặc tạm nó đi.\" (Albus)\r\n\r\n\"Cảm ơn anh... anh tên là gì?\" (Felisia)\r\n\r\n\"Cô có thể gọi tôi là... Albus.\" (Albus)\r\n\r\nCái tên đó khiến máu trong người tôi như đóng băng. Tôi ngước nhìn kỹ gương mặt anh và hoàn toàn chết lặng.\r\n\r\nDưới ánh sáng lờ mờ, gương mặt anh hiện ra như một thực thể bước ra từ huyền thoại cấm kỵ. Một vẻ đẹp phi thực, thanh tú đến nao lòng nhưng lại phảng phất hơi thở của tử thần. Làn da trắng sứ nhợt nhạt làm nổi bật đôi môi mỏng đang khẽ nhếch lên thành một nụ cười ẩn ý, đầy vẻ cợt nhả.\r\n\r\nĐôi mắt đỏ rực như hai viên hồng ngọc lấp lánh thứ ánh sáng sắc lạnh, có thể nhìn thấu tận tâm can người đối diện. Mái tóc trắng bạc tinh khiết như ánh trăng, dần chuyển sang sắc tím mộng mị ở phần đuôi, lòa xòa chạm vào hàng mi dài.\r\n\r\nAnh chậm rãi đưa ngón tay thon dài lên môi, ra hiệu cho một sự im lặng chết chóc.\r\n\r\n\"Có vẻ cô đã biết tôi là ai rồi? Shhhh... đừng hét lên nhé.\" (Albus)\r\n\r\nĐúng là anh ta.\r\n\r\nAlbus Caeles Ennoia.\r\n\r\nVị Hầu tước tối cao của Thánh Địa, một \"Sát Thần\" lừng danh với sự tàn bạo khiến những tôn giáo phải diệt vong. Kẻ mà chỉ cần nghe ai đó cầu nguyện trước mặt cũng sẽ gieo xuống án tử không chút xót thương.\r\n\r\nTệ hơn là tôi là người đã đào hôn anh ta.\r\n\r\nVà tôi... vừa hứa sẽ trao cho một kẻ như thế \"bất cứ thứ gì\".\r\n\r\nHy vọng anh ta không nhận ra mình là Irena...\r\n\r\n\"Đang suy nghĩ gì vậy, Felisia?\" (Albus)\r\n\r\nTiếng gọi của anh kéo tôi về thực tại. Albus đưa tay ra trước mặt tôi, một lời đề nghị không thể chối từ.\r\n\r\n\"Nắm lấy đi, để tôi đưa cô rời khỏi nơi này.\" (Albus)\r\n\r\n\"Vâng...\" (Felisia)\r\n\r\nTôi run rẩy đặt bàn tay mình vào tay anh. Trái ngược hoàn toàn với danh xưng Sát Thần máu lạnh, bàn tay ấy lại ấm áp đến lạ thường. Cảm giác này... liệu những giai thoại tàn bạo về anh có thực sự là sự thật?', 0, 1, 'chap-1:-cuoc-gap-go-dinh-menh', '2026-03-14 04:16:21'),
(2, 2, 'Khởi Đầu Hay Kết Thúc', '', 'Tôi là Gufi, thành viên trong bộ ba thợ săn cùng với Mystery và Cursen nhưng lạ thay thì tôi cảm thấy bản thân hơi vô dụng.\r\nNhận ra bản thân không đóng góp nhiều trong xuyên suốt hành trình giành Ấn ở Zima nơi được ví là địa ngục băng giá của tám Lãnh Địa. Trong khi Mystery cùng với Cursen đã phải rơi vào cảnh thập tử nhất sinh chỉ để sống sót khi bản thân tôi cứ giữ khư khư cái chấp niệm về sự sống không nên bị tước bỏ.\r\nĐặc biệt là tên Cursen ngu ngốc và đáng ghét ấy lại là người chinh phục được thử thách để mang về cho cả nhóm Ấn, còn Mystery thì đã không tiếc việc bị mất kiểm soát sức mạnh chỉ để đánh bại kẻ thù nhưng còn tôi thì lại chả có chiến công gì vẻ vang như thế cả. Và những gì tôi làm là ăn hôi thành quả của cả nhóm khi thành tích duy nhất bản thân có là người kết liễu Gấu Tuyết sau khi hai người kia đã đưa nó vào ngưỡng tử...\r\nTôi có thể thua một người như Mystery nhưng tên ngốc Cursen thì không bao giờ! \r\nChí ít thì đó là những lời mà tôi sẽ nói trước khi tới Carmesi, vùng đất của cát nóng và ánh mặt trời oi ả. Lúc vừa tới thì cả bọn đã bị một thứ gì đó làm cho chúng tôi mất ý thức trong một khoảng thời gian và khi tỉnh dậy thì nhận ra cả ba đã bị ai đó bán đi làm nô lệ ở một hầm mỏ khoáng sản hiếm hoi của Lãnh Địa này. Tôi hiện là hầu gái của tên trưởng hầm mỏ và trong giai đoạn mất ý thức thì tôi đã phải phục vụ hắn về mọi thứ mà cũng may tôi đã không bị kêu làm \'chuyện đó\' do tôi không phải gu của hắn.\r\nNghe hơi đau lòng nhưng tính ra số phận hiện tại của tôi còn tươi sáng hơn nếu so với Mystery và Cursen, hai người bọn họ phải đi vào sâu trong hầm mỏ để đào các khoáng sản. Tôi khá bất ngờ khi Cursen làm việc khá hiệu quả thậm chí là còn dư để bù cho hiệu quả của Mystery khi anh ta không thể sử dụng sức mạnh của mình khi bị mất ý thức.\r\nTheo thông tin có được thì cũng đã 2 năm kể từ khi chúng tôi mất ý thức và khi vừa có lại nó thì chúng tôi đã nhanh chóng lập kế hoạch để trốn thoát trong âm thầm vì cả ba chúng tôi đều không thể sử dụng sức mạnh của mình ở đây. Làm nô lệ ở Carmesi hay bất kì nơi nào khác ở cả 8 Lãnh Địa đều sẽ buộc phải đeo một cái vòng cổ phong ấn sức mạnh và nó còn có chức năng phát nổ nếu người đeo đi ra khỏi phạm vi mà cái vòng này chỉ định.\r\nThậm chí dù chúng tôi không chết vì vụ nổ thì cũng là một con đường chết khác đang được mở ra mà thôi, do tên trưởng hầm mỏ này không phải là tên lên chức bằng quan hệ mà là thực lực. Từng có lúc tôi nhìn hắn băm một tên nô lệ thành đống bầy nhầy chỉ bằng cách nhìn, có lẽ không có gì đáng nói nếu tôi không nhìn thấy tấm thẻ Hunter của người đó rớt xuống.\r\nĐó là thẻ Hunter có 4 ấn...\r\nĐối đầu với một kẻ như thế thì chúng tôi sẽ không dám mắc bất kì sai lầm nào.\r\n\r\n\"Gufi, em đi giặt ga giường cho chủ nhân đi! Hết giờ nghỉ rồi.\" (Alice)\r\n\r\nTôi quay mặt nhìn Alice, một góa phụ tuổi trung niên với khuôn mặt chứa đầy dấu vết sương gió của cuộc đời.\r\nCô ấy là trưởng hầu nữ của nơi này, nói cách khác thì tạm thời cô ấy là cấp trên của tôi nên tôi mĩm cười đáp.\r\n\r\n\"Vâng ạ.\" (Gufi)\r\n\r\nKế hoạch vẫn phải tiếp tục thực hiện nhưng không được quá gấp rút mà cần chờ đợi thời cơ chín mùi.\r\nTrước hết thì bản thân cần phải thực hiện trách nhiệm của một hầu gái nếu không thì tên trưởng hầm mỏ sẽ để ý đến sự bất thường. \r\nHắn dường như rất nhạy bén với sự thay đổi của những kẻ bên cạnh và đã có nhiều lần tôi thấy hắn nhanh chóng lấy mạng bất kì ai mà hắn nghĩ là đã lấy lại được ý thức. Sự thay đổi đó bao gồm cả hành động và lời nói cho nên nếu không muốn chết thì tôi và hai người kia phải trở thành diễn viên chuyên nghiệp.\r\n\r\n.\r\n.\r\n.\r\n\r\nChuyển cảnh tới Mystery và Cursen đang cắm cúi dùng cái cuốc của mình gõ xuống cạnh của những khoáng thạch dưới đất, mỗi cú gõ xuống đá là mỗi lần mà tiếng vang cất lên hòa mình vào vô vàn những tiếng gõ khác. Ở một nơi như hang mỏ thì những âm thanh này như tra tấn gián tiếp những người thợ mỏ, bởi vì họ không được phép dừng thứ âm thanh này lại dù nó có khó chịu như nào đi chăng nữa. Vì nếu không làm thì những chiếc roi da sẽ ngay lập tức tương tác với da của họ bởi những kẻ giám sát phía sau mỗi người.\r\nCursen nhẹ nhàng gõ lên lớp đá cứng dưới đất để đào được thành công thêm một viên khoáng sản nguyên vẹn, anh ta cầm lấy nó rồi vứt nó lên chiếc xe gỗ chở đầy những khoáng sản mà anh ấy kiếm được trong hôm nay. Nhìn Cursen có vẻ thuận lợi trong công việc thì Mystery bên cạnh là khổ sở vô cùng khi anh ta liên tục vung những nhát gõ đầy yếu ớt khiến cho người quản lý phía sau anh ấy liên tục dùng chiếc roi đánh tới khiến cho da thịt cũng phải bóc ra, dù vẻ mặt của Mystery không tỏ ra đau đớn nhưng ai nấy làm việc gần anh ta đều cảm thấy đau đớn hộ cho. Có vẻ sau lần mất kiểm soát trước thì anh ta đã mất đi một thứ gì đó.\r\n\r\n\"Ê cậu có ổn không đó?\" (Cursen)\r\n\"Hả?\" (Mystery)\r\n\r\nMystery nhìn lại cơ thể mình thì mới nhận ra mình bị thương, anh ta còn tỏ ra bất ngờ hơn người chứng kiến nó nữa.\r\n\r\n\"Tôi không nhận ra, nó chỉ khiến tôi có cảm giác lạnh lạnh chứ không đau đớn gì cả?\" (Mystery)\r\n\r\nÁnh mắt của Mystery bỗng trầm xuống dường như bản thân anh ta đã hiểu rõ được lý do mà mình không hề cảm thấy đau đớn cho nên đã không nói gì nữa mà vẫn tiếp tục công việc của mình một cách cố chấp, dù những vết thương đã lở loét khiến cho máu hoà làm một với mồ hôi. \r\nNhìn đau đớn vô cùng, thậm chí là tên quản lý đánh anh ta hồi nãy của bắt đầu cảm thấy khó chịu khi mặt của hắn trở xanh xao như muốn nôn ra ngay lập tức. Hắn dừng vung roi và rời đi ngay sau đó.\r\nHắn vừa rời đi thì những vết thương của Mystery bỗng chốc lành lại, cứ như là chúng chưa bao giờ tồn tại.\r\nAnh ta dừng công việc lại và gật đầu đầy ẩn ý với Cursen.\r\nThấy vậy Cursen cũng chỉ thở dài mà vung chiếc cuốc của mình đào nhiều loại khoáng sản rồi ném chúng lên chiếc xe của Mystery cho đến khi chất đầy đống đó tới một độ cao vừa đủ thì dừng lại.\r\n\r\n\"Có vẻ khả năng hồi phục của cậu không phải là sức mạnh nhỉ?\" (Cursen)\r\n\"Ừ, nó là khả năng bẩm sinh cho nên cái vòng chết tiệt này không cầm chế được.\" (Mystery)\r\n\"Mà nãy cậu bị làm sao vậy?\" (Cursen)\r\n\"Không có gì...\" (Mystery)\r\n\r\nCursen thở dài.\r\n\r\n\"Nếu cậu không muốn nói thì thôi.\r\nDù sao thì việc giữ một vài bí mật cũng đâu chuyện gì xấu xa đâu.\" (Cursen)\r\n\r\nMystery không nói gì cả.\r\n\r\n\"Tối nay là thời điểm chín mùi rồi nhỉ?\" (Cursen) \r\n\"Ừ, tối nay là cơ hội cuối cùng trong năm nay rồi.\" (Mystery)\r\n\r\nCursen và Mystery đẩy chiếc xe chở khoáng sản này tới chỗ quản lý khu để giao nộp, hắn kiểm tra rồi đưa cho cả hai những lá phiếu trao đổi vật phẩm trong ngục, hai người nhanh chóng tới đó để đổi những thứ không cần thiết cho việc trốn thoát để tránh bị để ý, sau này sẽ cố chế chúng lại thành những thứ cần thiết.\r\nCả hai người đó đi vài bước thì thấy hình bóng quen thuộc phía trên nên ngước mặt lên nhìn tôi đang phơi đồ trên cao.\r\nTôi bỗng nhận được cảm nhận được ánh nhìn nên quay mặt lại.\r\nHọ gật đầu và tôi cũng đáp lại theo, sau đó cả ba quay mặt rời đi.\r\nKế hoạch đã bắt đầu. ', 0, 1, 'khoi-dau-hay-ket-thuc', '2026-03-16 08:24:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

CREATE TABLE `danhmuc` (
  `id` int(10) NOT NULL,
  `tendanhmuc` varchar(255) NOT NULL,
  `slug_danhmuc` varchar(255) NOT NULL,
  `mota` varchar(255) NOT NULL,
  `kichhoat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`id`, `tendanhmuc`, `slug_danhmuc`, `mota`, `kichhoat`) VALUES
(1, 'Tiên Hiệp', 'tien-hiep', 'Tiên hiệp là thể loại truyện huyền ảo bắt nguồn từ văn hóa tu tiên của Trung Hoa, kể về hành trình tu luyện của nhân vật để trở thành tiên nhân. Nội dung thường xoay quanh việc tu luyện, tăng cảnh giới, luyện đan, pháp bảo, tông môn và chiến đấu giữa các ', 1),
(2, 'Viễn Tưởng', 'vien-tuong', 'Viễn tưởng là thể loại truyện tưởng tượng về những thế giới, công nghệ hoặc sự kiện chưa tồn tại, thường dựa trên giả thuyết khoa học hoặc ý tưởng về tương lai. Nội dung có thể liên quan đến du hành vũ trụ, trí tuệ nhân tạo, người ngoài hành tinh, công ng', 1),
(3, 'Hành Động', 'hanh-dong', 'Hành động: Thể loại truyện tập trung vào các cảnh chiến đấu, truy đuổi, phiêu lưu và xung đột căng thẳng, nhịp truyện nhanh và nhiều tình huống kịch tính.', 1),
(4, 'Lãng Mạn', 'lang-man', 'Lãng mạn: Thể loại truyện xoay quanh tình cảm và mối quan hệ yêu đương giữa các nhân vật, thường khai thác cảm xúc, sự gắn kết và phát triển tình yêu.', 1),
(5, 'Hài Hước', 'hai-huoc', 'Hài hước: Thể loại truyện được xây dựng để tạo tiếng cười cho người đọc thông qua tình huống trớ trêu, lời thoại dí dỏm hoặc hành động gây cười', 1),
(6, 'Psychology', 'psychology', 'Psychology là Thể loại truyện tập trung vào suy nghĩ, cảm xúc và trạng thái tinh thần của nhân vật, khai thác những xung đột nội tâm, động cơ hành động và sự phát triển tâm lý của họ.', 1),
(7, 'Drama', 'drama', 'Drama: Thể loại truyện tập trung vào xung đột cảm xúc, mâu thuẫn giữa các nhân vật và những tình huống căng thẳng trong cuộc sống, thường mang nhiều cảm xúc như buồn, đau khổ, hoặc bi kịch.', 1),
(8, 'Fantasy', 'fantasy', 'Fantasy: Thể loại truyện lấy bối cảnh thế giới tưởng tượng với các yếu tố ma thuật, sinh vật huyền bí, thần linh hoặc sức mạnh siêu nhiên.', 1),
(9, 'Phiêu Lưu', 'phieu-luu', 'Phiêu lưu: Thể loại truyện kể về hành trình khám phá, vượt qua thử thách và nguy hiểm của nhân vật ở những vùng đất mới hoặc trong những cuộc hành trình dài.', 1),
(10, 'Lịch Sử', 'lich-su', 'Lịch sử: Thể loại truyện lấy bối cảnh trong các giai đoạn lịch sử có thật, có thể dựa trên sự kiện, nhân vật hoặc bối cảnh của quá khứ.', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `truyen`
--

CREATE TABLE `truyen` (
  `id` int(11) NOT NULL,
  `tentruyen` varchar(255) NOT NULL,
  `tacgia` varchar(200) NOT NULL,
  `so_chuong` int(11) DEFAULT 0,
  `trang_thai` varchar(50) DEFAULT 'Đang ra',
  `tomtat` text NOT NULL,
  `danhmuc_id` int(11) NOT NULL,
  `hinhanh` varchar(255) NOT NULL,
  `luot_xem` int(11) DEFAULT 0,
  `slug_truyen` varchar(255) NOT NULL,
  `kichhoat` int(11) NOT NULL,
  `ngay_cap_nhat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `truyen`
--

INSERT INTO `truyen` (`id`, `tentruyen`, `tacgia`, `so_chuong`, `trang_thai`, `tomtat`, `danhmuc_id`, `hinhanh`, `luot_xem`, `slug_truyen`, `kichhoat`, `ngay_cap_nhat`) VALUES
(1, 'Whither All End', 'Akira', 0, 'Đang ra', 'đasadqqwdwq', 4, '1773452104_Gemini_Generated_Image_6tzfst6tzfst6tzf.png', 62, 'whither-all-end', 1, '2026-03-16 07:50:49'),
(2, 'Pehida', 'Akira-Phong', 0, 'Đang ra', 'Cuộc phiêu lưu xuyên 8 Lãnh Địa', 9, '1773649089_ZaniTimeout.png', 1, 'pehida', 1, '2026-03-16 09:05:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` int(1) DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `avatar`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Akira Kuro', 'akuro3104@gmail.com', NULL, '$2y$10$HX1N/pO9Cbii7Iw4Bpqf/OKNY7R3L.Wm0nlF4SX.Nq4zT3QemrwmW', NULL, 1, NULL, '2026-03-12 13:15:28', NULL),
(2, 'Nguyễn Tấn Vĩ', '123@gmail.com', NULL, '$2y$10$jbRjxUsOYzZvzTwxhLh3VOcyVHp31bJ/oV7kN4cHM2oNoIOnoHacS', NULL, 0, NULL, '2026-03-12 13:17:21', NULL),
(10, 'Phong', 'akuro3107@gmail.com', NULL, '$2y$10$U7BQcdOIdN6Yps7K1Ou4x.qe1.rCB/Mc0tV0.VacI8dAVmDJa5Vfa', NULL, 0, NULL, '2026-03-16 08:56:31', NULL),
(11, 'use1', '546@gmail.com', NULL, '$2y$10$dYzBYu8iNU/t68P9CM8e7uWE83NaADRpqZ7LmGcBtmezcruS56Uq.', NULL, 0, NULL, '2026-03-16 09:02:20', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `yeuthich`
--

CREATE TABLE `yeuthich` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `truyen_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_chapter_truyen` (`truyen_id`);

--
-- Chỉ mục cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `truyen`
--
ALTER TABLE `truyen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_truyen_danhmic` (`danhmuc_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `yeuthich`
--
ALTER TABLE `yeuthich`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_fav` (`user_id`,`truyen_id`),
  ADD KEY `fk_yeuthich_truyen` (`truyen_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chapter`
--
ALTER TABLE `chapter`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `truyen`
--
ALTER TABLE `truyen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `yeuthich`
--
ALTER TABLE `yeuthich`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chapter`
--
ALTER TABLE `chapter`
  ADD CONSTRAINT `fk_chapter_truyen` FOREIGN KEY (`truyen_id`) REFERENCES `truyen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `truyen`
--
ALTER TABLE `truyen`
  ADD CONSTRAINT `fk_truyen_danhmic` FOREIGN KEY (`danhmuc_id`) REFERENCES `danhmuc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `yeuthich`
--
ALTER TABLE `yeuthich`
  ADD CONSTRAINT `fk_yeuthich_truyen` FOREIGN KEY (`truyen_id`) REFERENCES `truyen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_yeuthich_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
