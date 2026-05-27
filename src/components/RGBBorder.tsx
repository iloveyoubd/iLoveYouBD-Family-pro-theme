import { motion } from "motion/react";

interface RGBBorderProps {
  height?: string;
  className?: string;
  disabled?: boolean;
  activeColor?: string;
}

export default function RGBBorder({ 
  height = "h-[3px]", 
  className = "", 
  disabled = false, 
  activeColor = "#00f0ff" 
}: RGBBorderProps) {
  if (disabled) {
    return (
      <div 
        className={`w-full ${height} ${className}`} 
        style={{ 
          backgroundColor: activeColor,
          boxShadow: `0 0 10px ${activeColor}55`
        }} 
      />
    );
  }

  return (
    <div className={`relative w-full overflow-hidden ${height} ${className}`}>
      {/* Absolute high-contrast futuristic linear gradient animating across */}
      <motion.div
        className="absolute inset-0 w-[400%] h-full bg-gradient-to-r from-cyan-500 via-pink-500 via-yellow-400 via-emerald-400 to-cyan-500"
        animate={{
          x: ["0%", "-50%"],
        }}
        transition={{
          repeat: Infinity,
          duration: 12,
          ease: "linear",
        }}
        style={{
          boxShadow: "0 0 12px rgba(0, 240, 255, 0.7), 0 0 4px rgba(255, 0, 128, 0.5)",
        }}
      />
    </div>
  );
}
